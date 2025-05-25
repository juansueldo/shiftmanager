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
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

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
                $this->createGoogleCalendarEvent($request, $calendar);
    
                return redirect()->route('calendar.index')->with('success', __('calendar.event_updated'));
            } else {
                $calendar = Calendar::create($data);
                $this->createGoogleCalendarEvent($request, $calendar);
                return redirect()->route('calendar.index')->with('success', __('calendar.event_created'));
            }
        } catch (\Exception $e) {
            Log::error('Error saving calendar: ' . $e->getMessage());
            return redirect()->route('calendar.index')->with('error', __('calendar.error_occurred') . $e->getMessage());
        }
    }

   protected function createGoogleCalendarEvent($request, $calendar)
   {
        $user = auth()->user();

        $client = new \Google_Client();
        $client->setAuthConfig(storage_path('app/google/credentials.json'));
        $client->addScope(\Google_Service_Calendar::CALENDAR);

        $expiresIn = now()->diffInSeconds($user->token_expires_at, false); 

        $client->setAccessToken([
            'access_token' => $user->google_token,
            'refresh_token' => $user->google_refresh_token,
            'expires_in' => max($expiresIn, 1),
            'created' => now()->subSeconds(max($expiresIn, 1))->timestamp,
        ]);

        if ($client->isAccessTokenExpired()) {
            $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

            if (isset($newToken['access_token'])) {
                $user->update([
                    'google_token' => $newToken['access_token'],
                    'token_expires_at' => now()->addSeconds($newToken['expires_in']),
                ]);

                $client->setAccessToken($newToken);
            } else {
                \Log::error('Error al refrescar el token de Google: ' . json_encode($newToken));
                return;
            }
        }

        $service = new \Google_Service_Calendar($client);

        $eventData = new \Google_Service_Calendar_Event([
            'summary'     => $request->title,
            'description' => $request->description,
            'start' => [
                'dateTime' => "{$request->date}T{$request->time}:00",
                'timeZone' => 'America/Argentina/Buenos_Aires',
            ],
            'end' => [
                'dateTime' => "{$request->date}T" . date('H:i:s', strtotime($request->time . ' +1 hour')),
                'timeZone' => 'America/Argentina/Buenos_Aires',
            ],
        ]);

        $calendarId = 'primary';

        if ($calendar->google_event_id) {
            // Ya existe: editar
            $event = $service->events->get($calendarId, $calendar->google_event_id);

            $event->setSummary($request->title);
            $event->setDescription($request->description);
            $event->setStart($eventData->getStart());
            $event->setEnd($eventData->getEnd());

            $updatedEvent = $service->events->update($calendarId, $event->getId(), $event);

        } else {
            // Nuevo evento
            $newEvent = $service->events->insert($calendarId, $eventData);
            $calendar->update(['google_event_id' => $newEvent->getId()]);
        }
    }

    public function delete($id)
    {
        $this->authorize('delete', Calendar::class);
        $calendar = Calendar::find($id);
        if ($calendar) {
            $calendar->delete();
            return redirect()->route('calendar.index')->with('success', __('calendar.event_deleted'));
        } else {
            return redirect()->route('calendar.index')->with('error', __('calendar.error_occurred'));
        }
    }


    

    

}
