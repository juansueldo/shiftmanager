<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $user = Auth::user();
        $customer = Customer::where('id', $user->customer_id)->get()->first();
        return view('settings.billing', compact('customer'));
    }

    public function create()
    {
        return view('settings.customers.create');
    }

    public function store(Request $request)
    {
        // Lógica para almacenar un nuevo cliente
        // Validación y almacenamiento de datos
        return redirect()->route('settings.customers.index')->with('success', __('customer.created_successfully'));
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
