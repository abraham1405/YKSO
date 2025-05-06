<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

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
        echo $request->getPassword();
        $email = (string)trim($request->email);
        $userCheck = User::where('email', '=', $email)->first();
        //$mensaje = (string)$userCheck->email;

        //
        if ($userCheck) {
            $userCheck->password = Hash::make($password);
            $userCheck->save();

            $alert = 'ok_alert';
            // $mensaje = 'La contraseña ha sido cambiada correctamente.';
            $mensaje = 'contraseña: '.$userCheck->password.' contraseña hash: '.$password;
            return view('app.change_password', [$alert => $mensaje]);
        }


        $alert = 'alert';
        $mensaje = 'No existe el usuario';
        return view('app.change_password', [$alert => $mensaje]);

    }
}
