<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rol;
class RolesController extends Controller
{
    protected $yamlconfig;

    public function __construct(){
        parent::__construct();
        $this->yamlconfig = $this->getYamlConfig('sections/roles');
    }

    public function index(){
        $user = Auth::user();
        $table = $this->yamlconfig['table'];
        return view('sections.roles', compact('table', 'user'));
    }

    public function data(Request $request){
        $query = Rol::filter($request->all());
        
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
        $role = null;

        if ($id > 0) {
            $role = Rol::find($id);
            if ($role) {
                foreach ($inputs as &$input) {
                    if (isset($role->{$input['name']})) {
                        $input['value'] = $role->{$input['name']};
                    }
                }
            }
        }

        return view('layouts.partials.form', compact('inputs', 'formdata', 'role'));
    }
    public function store(Request $request){
        if ($request->has('id') && $request->id && $request->id > 0) {
            $role = Rol::findOrFail($request->id);
            $role->update(['name'=>$request->name]);
            $roleUpdate=true;
        }else{
            $role = Rol::create(['name'=> $request->name, 'status'=> 1]);
            $roleUpdate=false;
        }
        return redirect()->route('roles.index')
                    ->with('success', __('roles.role_' . ($roleUpdate ? 'updated' : 'created')));
    }
    
}
