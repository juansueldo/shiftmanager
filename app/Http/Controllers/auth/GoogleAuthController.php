<?php

namespace App\Http\Controllers\auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
{
    return Socialite::driver('google')
        ->scopes([
            'openid',
            'profile',
            'email',
            'https://www.googleapis.com/auth/calendar'
        ])
        ->with(['access_type' => 'offline', 'prompt' => 'consent']) 
        ->redirect();
}


    public function callback()
{
    $googleUser = Socialite::driver('google')->user();

    // Separar nombre y apellido
    $names = explode(' ', $googleUser->name, 2);
    $firstname = $names[0];
    $lastname = $names[1] ?? '';

    // Buscar un usuario existente por google_id o email
    $existingUser = User::where('google_id', $googleUser->id)
        ->orWhere('email', $googleUser->email)
        ->first();

    if ($existingUser && $existingUser->customer_id) {
        // Si ya tiene un customer asociado, lo usamos
        $customer = Customer::find($existingUser->customer_id);
    } else {
        // Si no tiene customer asociado, intentamos buscar uno por email
        $customer = Customer::where('company_email', $googleUser->email)->first();

        // Si no existe, lo creamos
        if (!$customer) {
            $customer = Customer::create([
                'company_email' => $googleUser->email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'status' => 1,
            ]);
        }
    }

    // Crear o actualizar el usuario
    $user = User::updateOrCreate(
        ['email' => $googleUser->email],
        [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'customer_id' => $customer->id,
            'google_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'password' => bcrypt(str()->random(16)),
            'email_verified_at' => now(),
            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'token_expires_at' => now()->addSeconds($googleUser->expiresIn),
        ]
    );

    Auth::login($user);

    return redirect()->intended('/dashboard');
}

}
