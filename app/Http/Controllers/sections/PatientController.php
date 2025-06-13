<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
class PatientController extends Controller
{
    use AuthorizesRequests;
    protected $yamlconfig;

    public function __construct(){
        parent::__construct();
        $this->yamlconfig = $this->getYamlConfig('sections/patients');
    }

    public function index(){
        $user = Auth::user();
        $table = $this->yamlconfig['table'];
        return view('sections.patients', compact('table', 'user'));
    }

    public function data(Request $request){
        $query = Patient::filter($request->all());
        
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage + 1;
        $data = $query->paginate($perPage, ['*'], 'page', $page);

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

    public function store(StorePatientRequest $request){
        $this->authorize('create', Patient::class);

        $data = $request->validated();
        $id = $request->id;

        try {
            if ($id && $id != 0) {
                $patient = Patient::findOrFail($id);

                if (Patient::where('email', $request->email)->where('id', '!=', $id)->exists()) {
                    return redirect()->back()->with('error', __('patient.email_in_use'));
                }

                if (Patient::where('identifier', $request->identifier)->where('id', '!=', $id)->exists()) {
                    return redirect()->back()->with('error', __('patient.identifier_in_use'));
                }

                $patient->update($data);

                return redirect()->route('patients.index')->with('success', __('patient.patient_updated'));
            } else {
                $data['customer_id'] = Auth::user()->customer_id;
                if (Patient::where('email', $request->email)->exists()) {
                    return redirect()->back()->with('error', __('patient.email_in_use'));
                }

                if (Patient::where('identifier', $request->identifier)->exists()) {
                    return redirect()->back()->with('error', __('patient.identifier_in_use'));
                }

                Patient::create($data);

                return redirect()->route('patients.index')->with('success', __('patient.patient_created'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', __('messages.error_occurred') . $e->getMessage());
        }
    } 

}
