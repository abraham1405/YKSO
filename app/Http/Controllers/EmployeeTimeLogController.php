<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTimeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class EmployeeTimeLogController extends Controller
{
    public function start()
    {
        $sessionUser = session('user');
        $user = User::where('name', $sessionUser['name'])->first();
        $today = Carbon::today()->toDateString();

        $registro = EmployeeTimeLog::where('user_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($registro) {
            session(['entrada_marcada' => (bool)$registro->hora_entrada]);
            session(['salida_marcada' => (bool)$registro->hora_salida]);
            session(['descanso_inicio' => (bool)$registro->hora_inicio_descanso]);
            session(['descanso_fin' => (bool)$registro->hora_fin_descanso]);
        }

        return view('app.fichaje', compact('registro'));
    }

    public function marcar(Request $request)
    {
        $accion = $request->input('accion');
        $sessionUser = session('user');
        $userId = $sessionUser['id'];
        $user = User::where('id', $userId)->first();
        $today = Carbon::today()->toDateString();

        $registro = EmployeeTimeLog::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today]
        );

        $ahora = Carbon::now();

        switch ($accion) {
            case 'entrada':
                if ($registro->hora_entrada) {
                    // Ya hay entrada marcada
                    return back()->withErrors('Ya has marcado la entrada hoy.');
                }
                $registro->hora_entrada = $ahora;
                session(['entrada_marcada' => true]);
                $registro->save();

                break;

            case 'salida':
                if (!$registro->hora_entrada) {
                    return back()->withErrors('Debes marcar la entrada primero.');
                }
                if ($registro->hora_salida) {
                    return back()->withErrors('Ya has marcado la salida hoy.');
                }
                $registro->hora_salida = $ahora;
                session(['salida_marcada' => true]);

                // Calcular horas trabajadas
                $entrada = Carbon::parse($registro->hora_entrada);
                $horasTrabajadas = $entrada->diffInMinutes($ahora) / 60;
                $registro->horas_trabajadas = round($horasTrabajadas, 2);

                // Limpiar sesión descanso si descanso completo
                if ($registro->hora_inicio_descanso && $registro->hora_fin_descanso) {
                    session()->forget(['descanso_inicio', 'descanso_fin']);
                }
                $registro->save();
                Artisan::call('app:actualizar-horas-totales-todos-los-meses');


                break;

            case 'descanso_inicio':
                if ($registro->hora_inicio_descanso) {
                    return back()->withErrors('Ya has marcado inicio de descanso.');
                }
                $registro->hora_inicio_descanso = $ahora;
                session(['descanso_inicio' => true]);
                $registro->save();

                break;

            case 'descanso_fin':
                if (!$registro->hora_inicio_descanso) {
                    return back()->withErrors('Debes marcar inicio de descanso primero.');
                }
                if ($registro->hora_fin_descanso) {
                    return back()->withErrors('Ya has marcado fin de descanso.');
                }
                $registro->hora_fin_descanso = $ahora;
                session(['descanso_fin' => true]);

                $inicio = Carbon::parse($registro->hora_inicio_descanso);
                $descanso = $inicio->diffInMinutes($ahora) / 60;
                $registro->horas_descanso = round($descanso, 2);

                $sancion = $descanso > 0.5 ? round($descanso - 0.5, 2) : 0;
                $registro->sancion_horas = $sancion;
                $registro->save();

                break;
            case 'comida_inicio':
                $registro->hora_inicio_comida = $ahora;
                session(['comida_inicio' => true]);
                $registro->save();

                break;

            case 'comida_fin':
                $registro->hora_fin_comida = $ahora;
                session(['comida_fin' => true]);
                if ($registro->hora_inicio_comida) {
                    $inicio = Carbon::parse($registro->hora_inicio_comida);
                    $duracionComida = $inicio->diffInMinutes($ahora) / 60;
                    $registro->horas_comida = round($duracionComida, 2);
                    $sancion = $duracionComida > 1 ? round($duracionComida - 1, 2) : 0; // Máximo 1 hora
                    $registro->sancion_comida = $sancion;
                }
                $registro->save();

                break;

            default:
                return back()->withErrors('Acción no válida.');
        }

        return redirect()->route('fichar')->with('success', 'Registro actualizado correctamente.');
    }
}