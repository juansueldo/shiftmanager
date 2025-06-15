<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Customer;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $request->validate([
                'firstname' => 'required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'terms' => 'required|accepted',
            ], [
                'firstname.required' => __('register.firstname_error_required'),
                'lastname.required' => __('register.lastname_error_required'),
                'email.required' => __('register.email_error_required'),
                'email.email' => __('register.email_error_invalid'),
                'email.unique' => __('register.email_error_unique'),
                'password.required' => __('register.password_error_required'),
                'password.min' => __('register.password_minlength'),
                'password.confirmed' => __('register.password_error_confirm'),
                'terms.required' => __('register.terms_required'),
                'terms.accepted' => __('register.terms_accepted'),
            ]);

            $customer = Customer::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'company_email' => $request->email,
            ]);

            // Crear un nuevo usuario
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'customer_id' => $customer->id,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'avatar' => 'http://127.0.0.1:8000/storage/uploads/users/9bcDcCzzjy.png'
            ]);

            RoleUser::create(
                ['user_id' => $user->id, 'role_id' => 1], 
            );

            // Autenticar al usuario registrado
            Auth::login($user);

            // Redirigir al dashboard
            return redirect()->route('dashboard.index');
        } catch (\Exception $e) {
            return redirect()->route('register.index')->with('error', __('register.error'));
        }
    }
}
