<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    protected $yamlconfig;

    public function __construct(){
        parent::__construct();
        $this->yamlconfig = $this->getYamlConfig('sections/statuses');
    }

    public function index(){
        $user = Auth::user();
        $table = $this->yamlconfig['table'];
        return view('sections.statuses', compact('table', 'user'));
    }

    public function data(Request $request){
        $query = Status::filter($request->all());
        
        $perPage = $request->input('length', 10);
        $page = $request->input('start', 0) / $perPage + 1;
        $data = $query->paginate($perPage, ['*'], 'page', $page);

        foreach ($data as $key => $value) {
            $data[$key]['name']= $this->showStatus($data[$key]['name']);
            $data[$key]['actions'] = $this->getActions($this->yamlconfig['table']['actions'], [$value['id']]); // Puedes agregar más lógica aquí
        }

        return response()->json([
            'data' => $data->items(),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
        ]);
    }
}
