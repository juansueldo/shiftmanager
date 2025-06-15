<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerController extends Controller
{
    protected $yamlconfig;
    public function __construct()
    {
        parent::__construct();
        $this->yamlconfig = $this->getYamlConfig('settings/customer');
    }

    public function index()
    {
        $user = Auth::user();
        $inputs = $this->yamlconfig['inputs'];
        $formdata = $this->yamlconfig['form'];
        $customer = Customer::where('id', $user->customer_id)->get()->first();
        foreach ($inputs as &$input) {
            if (isset($customer->{$input['name']})) {
                $input['value'] = $customer->{$input['name']};
            }
        }
        return view('settings.billing', compact('inputs', 'formdata', 'customer'));
    }

    public function create()
    {
        return view('settings.customers.create');
    }

    public function store(Request $request)
    {
        $customer = Customer::find($request->id);
        $customer->update($request->all());
        return redirect()->route('settings.billing')->with('success', __('customer.created_successfully'));
    }

    public function edit($id)
    {
        // Lógica para editar un cliente existente
        return view('settings.customers.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Lógica para actualizar un cliente existente
        return redirect()->route('settings.customers.index')->with('success', __('customer.updated_successfully'));
    }
}
