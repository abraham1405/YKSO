<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $user = Auth::user();
        $alert = 'alert';

        $user = Auth::user();

        if (!Auth::check()) {
            return redirect('/')->with('alert', 'Usuario no autenticado');

        }

        $role = $user->role;

        if ($role === 'admin') {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            $targetUser = User::where('email', $request->email)->first();

            if (!$targetUser) {
                return view('app.change_password', [$alert => 'No existe el usuario con ese correo.']);
            }

            $targetUser->password = Hash::make($request->password);
            $targetUser->save();

            return view('app.change_password', ['ok_alert' => 'Contraseña actualizada correctamente para el usuario.']);
        }
        else {
            $this->passwordRequest($request, $user);
        }

    }

    private function passwordRequest(Request $request, $Account)
    {
        if ($request->isMethod('get')) {
            return view('app.change_password');
        }

        $userData = session('user');
        if (!$userData) {
            return redirect()->route('login')->with('alert', 'Sesión expirada.');
        }

        $password = trim($request->password);

        if (!$this->password_is_correct($password)) {
            return view('app.change_password', ['alert' => 'La contraseña debe tener mínimo 8 caracteres, letras y números.']);
        }

        $Account->password = Hash::make($password);
        $Account->save();

        return view('app.change_password', ['ok_alert' => 'Contraseña actualizada correctamente.']);
    }
}
