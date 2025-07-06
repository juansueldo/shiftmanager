<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomersController extends Controller
{
    use AuthorizesRequests;
    protected $yamlconfig;

    public function __construct(){
        parent::__construct();
        $this->yamlconfig = $this->getYamlConfig('sections/customers');
    }

    public function index(){
        $user = Auth::user();
        $table = $this->yamlconfig['table'];
        return view('sections.customers', compact('table', 'user'));
    }

    public function data(Request $request){
        $query = Customer::filter($request->all());
        
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

}
