<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConnectionsController extends Controller
{
    public function index()
    {
        return view('settings.connections');
    }

}
