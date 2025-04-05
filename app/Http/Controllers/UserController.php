<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends AuthController
{
    public function start()
    {
        $users = User::all();
        return view('admin.users', ['users' => $users]);
    }

    public function add(Request $request)
    {
        $alert = 'alert';
        $mensaje = 'Datos inválidos.';

        $name = (string)trim($request->name);
        $email = (string)trim($request->email);
        $password = (string)trim($request->password);
        $role = (string)trim($request->role);

        if ($this->password_is_correct($password) && !$this->user_exists($email)) {

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
                'photo' => $photo ?? '/user/admin.png',
            ]);

            $alert = 'ok_alert';
            $mensaje = 'Usuario agregado correctamente.';
        }

        $users = User::all();
        return view('admin.users', [$alert => $mensaje, 'users' => $users]);
    }

    public function delete($id)
    {
        $alert = 'alert';
        $mensaje = 'Error al eliminar el usuario.';

        $user = User::find($id);

        if ($user) {

            $user->delete();
            $alert = 'ok_alert';
            $mensaje = 'Usuario eliminado.';
        }

        $users = User::all();
        return view('admin.users', [$alert => $mensaje, 'users' => $users]);
    }
}
