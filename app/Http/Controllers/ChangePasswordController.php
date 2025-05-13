<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Session;
use function Laravel\Prompts\password;

class ChangePasswordController extends AuthController
{
    public function start()
    {
        return view('app.change_password');
    }

    public function input(Request $request)
    {
        $sessionUser = session('user');

        // Validación de contraseña segura
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-zA-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ]);

        if ($validator->fails()) {
            return view('app.change_password', [
                'alert' => 'La contraseña no cumple con los requisitos de seguridad.',
                'errors' => $validator->errors()
            ]);
        }

        if ($sessionUser['role'] === 'admin') {
            $targetUser = User::where('email', $request->email)->first();

            if (!$targetUser) {
                return view('app.change_password', ['alert' => 'No existe el usuario con ese correo.']);
            }

            $targetUser->password = Hash::make($request->password);
            $targetUser->save();

            return view('app.change_password', ['ok_alert' => 'Contraseña actualizada correctamente para ' . $targetUser->name]);
        } else {
            $Account = User::where('name', $sessionUser['name'])->first();

            if (!$Account) {
                return view('app.change_password', ['alert' => 'Error al encontrar el usuario autenticado.']);
            }

            $Account->password = Hash::make($request->password);
            $Account->save();

            return view('app.change_password', ['ok_alert' => 'Tu contraseña fue actualizada correctamente.']);
        }
    }
}
