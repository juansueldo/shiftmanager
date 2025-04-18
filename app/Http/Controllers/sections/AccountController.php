<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use stdClass;


class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('sections.account', compact('user'));
    }

    public function update(Request $request)
    {
        $data = $request->only(['firstname', 'lastname', 'email']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        if ($request->avatar) {
            $data['avatar'] = $this->saveFile($request->avatar, 'users');
        }
        $user = User::find($request->id);
        $user->update($data);
        
        return redirect()->route('account.index')->with('success', 'Perfil actualizado correctamente');
    }

}
