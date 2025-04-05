<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends AuthController
{
    public function start()
    {
        return view('app.change_password');
    }

    public function input(Request $request)
    {
        $alert = 'alert';
        $mensaje = 'Error en los datos introducidos.';
        
        $password = (string)trim($request->password);
        $new_password = (string)trim($request->new_password);

        //
        if ($password == $new_password) {
            $alert = 'alert';
            $mensaje = 'No puedes poner lo mismo en ambos campos.';
        }

        //
        $user = User::find(session('user.id'));

        if ($user && Hash::check($password, $user->password)) {

            $user->password = Hash::make($new_password);
            $user->save();

            $alert = 'ok_alert';
            $mensaje = 'La contraseña ha sido cambiada correctamente.';
        }

        return view('app.change_password', [$alert => $mensaje]);
    }
}
