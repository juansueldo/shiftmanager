<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
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
                }
            }
        }

        return view('layouts.partials.form', compact('inputs', 'formdata', 'user'));
    }

    public function store(StoreDoctorRequest $request){
       
        $this->authorize('create', Doctor::class);
        try {
            Doctor::create($request->validated());

            return redirect()->route('doctors.index')->with('success', 'Doctor created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }
}
