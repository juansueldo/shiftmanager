<?php

namespace App\Http\Controllers\auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
        ->with(['access_type' => 'offline', 'prompt' => 'consent']) // Muy importante para obtener refresh token
        ->redirect();
}


    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Separar nombre y apellido
        $names = explode(' ', $googleUser->name, 2);
        $firstname = $names[0];
        $lastname = isset($names[1]) ? $names[1] : '';

        $user = User::updateOrCreate([
            'email' => $googleUser->email,
        ], [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'google_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            // Puedes dejar password vacío o poner un valor random
            'password' => bcrypt(str()->random(16)),
            'email_verified_at' => now(),

            'google_token' => $googleUser->token,
            'google_refresh_token' => $googleUser->refreshToken,
            'token_expires_at' => now()->addSeconds($googleUser->expiresIn),
        ]);

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
