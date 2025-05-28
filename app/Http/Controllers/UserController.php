<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function edit(User $user)
    {
        return view('user.edit',['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        //$user->lastname = $request->input('lastname');
        $user->email = $request->input('email');

        $user->save();

        return redirect(session('url_from'))->with('success', 'Usuario editado');
    }

    public function update_password(Request $request, User $user)
    {
        if($request->input('password') == $request->input('repeat_password'))
        {
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }
        else 
            return back()->with('error', 'Fallo en cambiar contraseña');

        return redirect(session('url_from'))->with('success', 'Contraseña editada');
    }
}
