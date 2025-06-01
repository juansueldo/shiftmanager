<?php

namespace App\Http\Controllers\auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\RoleUser;
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


    public function callback(){
        $googleUser = Socialite::driver('google')->user();
        $is_admin = false;

        $names = explode(' ', $googleUser->name, 2);
        $firstname = $names[0];
        $lastname = $names[1] ?? '';

        $existingUser = User::where('google_id', $googleUser->id)
            ->orWhere('email', $googleUser->email)
            ->first();

        if ($existingUser && $existingUser->customer_id) {
            $customer = Customer::find($existingUser->customer_id);
        } else {
            $customer = Customer::where('company_email', $googleUser->email)->first();
            if (!$customer) {
                $is_admin = true;
                $customer = Customer::create([
                    'company_email' => $googleUser->email,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'status' => 1,
                ]);
            }
        }

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
        if($is_admin === true){
            RoleUser::updateOrCreate(
                ['user_id' => $user->id, 'role_id' => 1], 
                ['status_id' => 1] 
            );
        }

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }

}
