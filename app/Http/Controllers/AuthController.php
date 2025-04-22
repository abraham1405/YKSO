<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function comp()
    {
        if (Session::has('user')) {
            return view('app.home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $email = trim($request->email);
        $password = trim($request->password);

        $user = User::where('email', '=', $email)->first();

        if ($user && Hash::check($password, $user->password)) {

            Session::put('user', [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
                'photo' => $user->photo
            ]);

            return view('app.home', ['ok_alert' => 'Bienvenido a YKSO ' . (string)$user->name. '.']);
        }

        return view('auth.login', ['alert' => 'Usuario incorrecto.']);
    }

    public function logout()
    {
        Session::forget('user');
        return view('auth.login', ['alert' => 'Sesión cerrada.']);
    }

    //
    protected function password_is_correct(string $password): bool
    {
        $validator = Validator::make(
            ['password' => $password],
            [
                'password' => [
                    'required',
                    'string',
                    Password::min(8)
                        ->letters()
                        ->numbers()
                ]
            ]
        );

        return !$validator->fails();
    }

    protected function user_exists(string $email): bool
    {
        if (User::where('email', $email)->exists()) {
            return 1;
        }

        return 0;
    }
}
