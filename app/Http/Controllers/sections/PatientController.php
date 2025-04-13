<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PatientController extends Controller
{
    use AuthorizesRequests;
    protected $yamlconfig;

    public function __construct(){
        $this->yamlconfig = $this->getYamlConfig('sections/patients');
    }

    public function index(){
        $table = $this->yamlconfig['table'];
        return view('sections.patients', compact('table'));
    }

    public function data(Request $request){
        $query = Patient::filter($request->all());
        
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
        $patient = null;

        if ($id > 0) {
            $patient = Patient::find($id);
            if ($patient) {
                foreach ($inputs as &$input) {
                    if (isset($patient->{$input['name']})) {
                        $input['value'] = $patient->{$input['name']};
                    }
                }
            }
        }

        return view('layouts.partials.form', compact('inputs', 'formdata', 'patient'));
    }

    public function checkIdentifier(Request $request){
        $patient = Patient::where('identifier', $request->identifier)->first();

        return response()->json([
            'firstname' => $patient->firstname ?? '',
            'lastname' => $patient->lastname ?? '',
        ]);
    }

    public function store(StorePatientRequest $request)
{
    $this->authorize('create', Patient::class);

    $data = $request->validated();
    $id = $request->id;

    try {
        if ($id && $id != 0) {
            // Modo editar
            $patient = Patient::findOrFail($id);

            // Verificar si el email o el identificador ya están en uso por otro paciente
            if (Patient::where('email', $request->email)->where('id', '!=', $id)->exists()) {
                return redirect()->back()->with('error', 'El email ya está en uso.');
            }

            if (Patient::where('identifier', $request->identifier)->where('id', '!=', $id)->exists()) {
                return redirect()->back()->with('error', 'El identificador ya está en uso.');
            }

            $patient->update($data);

            return redirect()->route('patients.index')->with('success', 'Paciente actualizado correctamente.');
        } else {
            // Modo crear
            if (Patient::where('email', $request->email)->exists()) {
                return redirect()->back()->with('error', 'El email ya está en uso.');
            }

            if (Patient::where('identifier', $request->identifier)->exists()) {
                return redirect()->back()->with('error', 'El identificador ya está en uso.');
            }

            Patient::create($data);

            return redirect()->route('patients.index')->with('success', 'Paciente creado correctamente.');
        }

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
    }
}

}
