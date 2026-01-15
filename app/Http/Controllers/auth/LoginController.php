<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(){
        parent::__construct();
    }
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect to tenant-specific dashboard
            $user = Auth::user();
            if ($user->customer && $user->customer->slug) {
                return redirect()->route('dashboard.index', ['slug' => $user->customer->slug]);
            }

            // Fallback to home page if no customer or slug (should not happen in normal flow)
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => __('login.login_error'),
        ])->onlyInput('email');
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
