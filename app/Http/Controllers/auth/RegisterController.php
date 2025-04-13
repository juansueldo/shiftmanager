<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    /*public function store(RegisterRequest $request)
    {
        // Crear un nuevo usuario
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'images/profile/avatar.png'
        ]);

        // Autenticar al usuario registrado
        Auth::login($user);

        // Redirigir al dashboard
        return redirect()->route('dashboard.index');
    }*/

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => 'images/profile/avatar.png'
        ]);

        // Autenticar al usuario registrado
        Auth::login($user);

        // Redirigir al dashboard
        return redirect()->route('dashboard.index');
    }
}
