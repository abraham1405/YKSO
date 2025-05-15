<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserData;

class UserController extends AuthController
{
    // Función para listar todos los usuarios
    public function start()
    {
        $users = User::all();
        return view('admin.users', ['users' => $users]);
    }

    // Función para agregar un nuevo usuario
    public function add(Request $request)
    {
        $alert = 'alert';
        $mensaje = 'Datos inválidos.';

        // Recibiendo los datos del formulario
        $name = (string)trim($request->name);
        $email = (string)trim($request->email);
        $password = (string)trim($request->password);
        $role = (string)trim($request->role);

        // Verificar que la contraseña sea válida y que el usuario no exista
        if ($this->password_is_correct($password) && !$this->user_exists($email)) {

            // Crear el usuario
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
                'photo' => $photo ?? '/user/admin.png',
            ]);

            // Si el rol es "empleado", entonces crear la entrada en la tabla 'user_data'
            if ($role === 'empleado') {
                UserData::create([
                    'user_id' => $user->id,  // Usamos el id del usuario creado
                    'birth_date' => $request->birth_date,
                    'address' => $request->address,
                    'company_assigned' => $request->company_assigned,
                    'entry_date' => now(),
                    'emergency_contact' => $request->emergency_contact,
                ]);
            }

            $alert = 'ok_alert';
            $mensaje = 'Usuario agregado correctamente.';
        }

        $users = User::all();
        return view('admin.users', [$alert => $mensaje, 'users' => $users]);
    }

    // Función para eliminar un usuario
    public function delete($id)
    {
        $alert = 'alert';
        $mensaje = 'Error al eliminar el usuario.';

        $user = User::find($id);

        if ($user) {
            // Eliminar el usuario
            $user->delete();
            $alert = 'ok_alert';
            $mensaje = 'Usuario eliminado.';
        }

        $users = User::all();
        return view('admin.users', [$alert => $mensaje, 'users' => $users]);
    }

    // Función para mostrar el listado de empleados
    public function modificarEmpleados()
    {
        // Obtener los usuarios con rol 'empleado' junto con su información adicional
        $empleados = User::where('role', 'empleado')->with('userData')->get();
        return view('admin.modificar_empleados', compact('empleados'));
    }

    // Función para actualizar la información de un empleado
    public function actualizarEmpleado(Request $request, $id)
    {
        // Validación de los datos
        $request->validate([
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'company_assigned' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:255',
        ]);

        // Buscar al usuario
        $user = User::findOrFail($id);

        // Obtener o crear los datos del usuario
        $data = $user->userData ?? new UserData(['user_id' => $id]);

        // Actualizar la información
        $data->birth_date = $request->birth_date;
        $data->address = $request->address;
        $data->company_assigned = $request->company_assigned;
        $data->emergency_contact = $request->emergency_contact;
        $data->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('modificar_empleados')->with('ok_alert', 'Información del empleado actualizada correctamente.');
    }

    // Función para mostrar el listado de empleados
    public function informacion()
    {
        $user = session('user');
        $userId = $user['id'];
        // Obtener los usuarios con rol 'empleado' junto con su información adicional
        $empleado = User::where('id', $userId)->with('userData')->first();
        return view('app.User_data', compact('empleado'));
    }
}