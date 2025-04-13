<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('sections.account', compact('user'));
    }
}
