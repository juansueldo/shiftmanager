<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConnectionsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $google = !empty($user->google_token);
        return view('settings.connections', compact('google'));
    }

}
