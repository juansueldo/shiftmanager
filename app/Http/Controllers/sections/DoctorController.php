<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Availabilities;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDoctorRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    use AuthorizesRequests;
    protected $yamlconfig;

    public function __construct()
    {
        parent::__construct();
        $this->yamlconfig = $this->getYamlConfig('sections/doctors');
    }

    public function index()
    {
        $user = Auth::user();
        $table = $this->yamlconfig['table'];
        return view('sections.doctors', compact('table', 'user'));
    }

    public function data(Request $request){
        $query = Doctor::filter($request->all());
        
        // Paginación para DataTables
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage + 1;
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        // Formatear datos
        foreach ($data as $key => $value) {
            $data[$key]['status_name']= $this->showStatus($data[$key]['status_name']);
            $data[$key]['actions'] = $this->getActions($this->yamlconfig['table']['actions'], [$value['id']]); // Puedes agregar más lógica aquí
        }

        return response()->json([
            'data' => $data->items(),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
        ]);
    }

    public function add($id=0){
        $inputs = $this->yamlconfig['inputs'];
        $formdata = $this->yamlconfig['form'];
        $user = null;

        if ($id > 0) {
            $user = Doctor::find($id);
            if ($user) {
                foreach ($inputs as &$input) {
                    if (isset($user->{$input['name']})) {
                        $input['value'] = $user->{$input['name']};
                    }
                    if ($input['name'] === 'specialties') {
                        foreach($user->specialties as $specialty){
                            $options[] = [
                                'id' => $specialty->id,
                                'text' => $specialty->name,
                            ];
                        }
                        $input['selected_data'] = $options;
                    }
                }
            }
        }


        return view('layouts.partials.form', compact('inputs', 'formdata', 'user'));
    }
    public function saveHours(Request $request){
       foreach ($request->days as $day) {
        Availabilities::create([
            'doctor_id' => $request->doctor_id,
            'specialty_id' => $request->specialties,
            'day' => $day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status_id' => 1,
            ]);
        }       

        return redirect()->route('doctors.index')->with('success', __('doctors.hours_created'));
    }
    public function store(StoreDoctorRequest $request)
    {
        $this->authorize('create', Doctor::class);
    
        try {
            $data = $request->validated();
            $specialtyIds = $request->input('specialties', []);
    
            // Si viene el ID, actualizamos
            if ($request->has('id')) {
                $doctor = Doctor::findOrFail($request->id);
                $doctor->update($data);
            } else {
                $doctor = Doctor::create($data);
            }
    
            // Manejo de especialidades
            if (is_array($specialtyIds)) {
                // Obtener las actuales del doctor
                $currentSpecialties = $doctor->specialties()->pluck('specialty_id')->toArray();
    
                // Desactivar las que ya no están
                $specialtiesToDeactivate = array_diff($currentSpecialties, $specialtyIds);
                if (!empty($specialtiesToDeactivate)) {
                    $doctor->specialties()->updateExistingPivot($specialtiesToDeactivate, ['status_id' => 3]);
                }
    
                // Activar o crear las nuevas
                foreach ($specialtyIds as $specialtyId) {
                    $doctor->specialties()->syncWithoutDetaching([
                        $specialtyId => ['status_id' => 1]
                    ]);
                }
            }
    
            return redirect()->route('doctors.index')->with('success', __('doctors.doctor_' . ($request->has('id') ? 'updated' : 'created')));
    
        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error_occurred') . $e->getMessage());
        }
    }
    
    public function setHours($id){
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return redirect()->back()->with('error', __('messages.error_occurred'));
        }
        $inputs = $this->yamlconfig['inputs_hours'];
        foreach($inputs as &$input){ // Usamos &$input para modificar el array original
            if($input['name'] == 'specialties'){
                $options = []; // Inicializamos $options como un array vacío
                foreach($doctor->specialties as $specialty){
                    $options[] = [
                        'value' => $specialty->id,
                        'text' => $specialty->name,
                    ];
                }
                $input['options'] = $options;
            }else if($input['name'] == 'doctor_id'){
                $input['value'] = $doctor->id;
            }
        }
        $formdata = $this->yamlconfig['form_hours'];
        return view('layouts.partials.form', compact('inputs', 'formdata', 'doctor'));
    }

    public function checkspecialty(Request $request){
        print_r($request->all());
    }
}
