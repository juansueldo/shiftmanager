<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index(){
        $user = Auth::user();
        $customers = Customer::all();
        return view('sections.chat', compact('user', 'customers'));
    }
    public function start($id){
        return view('sections.box');
    }
    public function send(Request $request){
        $user = Auth::user();
        $message = $request->input('message');
        // Aquí puedes guardar el mensaje en la base de datos o enviarlo a través de un servicio de mensajería
        return response()->json(['status' => 'success', 'message' => $message, 'user' => $user->name]);
    }
}
