<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    protected $yamlconfig;

    public function __construct()
    {
        $this->yamlconfig = $this->getYamlConfig('sections/specialties');
    }

    public function index()
    {
        $table = $this->yamlconfig['table'];
        return view('sections.specialties', compact('table'));
    }

    public function data(Request $request){
        $query = Specialty::filter($request->all());
        
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
        $specialty = null;

        if ($id > 0) {
            $specialty = Specialty::find($id);
            if ($specialty) {
                foreach ($inputs as &$input) {
                    if (isset($specialty->{$input['name']})) {
                        $input['value'] = $specialty->{$input['name']};
                    }
                }
            }
        }

        return view('layouts.partials.form', compact('inputs', 'formdata', 'specialty'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:specialties,name,' . $request->id,
        ]);

        try {
            if ($request->id > 0) {
                $specialty = Specialty::findOrFail($request->id);
                $specialty->update(['name' => $request->input('name')]);
                return redirect()->route('specialty.index')->with('success', 'Specialty updated successfully!');
            } else {
                Specialty::create(['name' => $request->input('name')]);
                return redirect()->route('specialty.index')->with('success', 'Specialty created successfully!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function list(){
        $specialties= Specialty::all();
        $data=[];
        foreach($specialties as $specialty){
            $data[]=[
                'value' => $specialty->id,
                'text' => $specialty->name,
            ];
        }
        return response()->json($data);
    }

}
