<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCalendarRequest;
use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Patient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    use AuthorizesRequests;    
    protected $yamlconfig;

    public function __construct()
    {
        parent::__construct();
        $this->yamlconfig = $this->getYamlConfig('/sections/calendar');
    }
    public function index()
    {
        $user= Auth::user();
        $calendarevents = Calendar::all();
        return view('sections.calendar', compact('calendarevents', 'user'));
    }

    public function add($id = 0)
    {
        $inputs = $this->yamlconfig['inputs'];
        $formdata = $this->yamlconfig['form'];
        $event = null;

        if ($id > 0) {
            $event = Calendar::find($id);
            if ($event) {
                $patient = Patient::find($event->patientid);
                foreach ($inputs as &$input) {

                    if (isset($event->{$input['name']})) {
                        if($input['name'] === 'date'){
                            $input['value'] = $event->getDateFormat();
                        }else{
                            $input['value'] = $event->{$input['name']};
                        }
                    }else if($input['name'] === 'time'){
                        $input['value'] = $event->getTimeFormat();
                    }
                    else{
                        $input['value'] = $patient->{$input['name']};
                    }
                }
            }
        }

        return view('layouts.partials.form', compact('inputs', 'formdata', 'event'));
    }

    public function store(StoreCalendarRequest $request)
    {
        $this->authorize('create', Calendar::class);
    
        // Buscar o crear paciente
        $patient = Patient::where('identifier', $request->identifier)->first();
    
        if (!$patient) {
            try {
                $patient = Patient::create([
                    'firstname'  => $request->firstname,
                    'lastname'   => $request->lastname,
                    'identifier' => $request->identifier,
                    'status'     => 1,
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating patient: ' . $e->getMessage());
                return redirect()->route('calendar.index')->with('error', __('calendar.error_ocurred')  . $e->getMessage());
            }
        }
    
        try {
            $data = [
                'title'       => $request->title,
                'description' => $request->description,
                'date'        => "{$request->date} {$request->time}:00",
                'patientid'   => $patient->id,
            ];
    
            if ($request->filled('id') && $request->id != 0){
                // Es una edición
                $calendar = Calendar::find($request->id);
                if (!$calendar) {
                    return redirect()->route('calendar.index')->with('error', __('calendar.error_occurred'));
                }
    
                $calendar->update($data);
    
                return redirect()->route('calendar.index')->with('success', __('calendar.event_updated'));
            } else {
                // Es un nuevo turno
                Calendar::create($data);
    
                return redirect()->route('calendar.index')->with('success', __('calendar.event_created'));
            }
        } catch (\Exception $e) {
            Log::error('Error saving calendar: ' . $e->getMessage());
            return redirect()->route('calendar.index')->with('error', __('calendar.error_occurred') . $e->getMessage());
        }
    }
    

    

}
