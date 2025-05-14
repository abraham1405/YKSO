<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTimeLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeTimeLogController extends Controller
{
    public function start()
    {
        return view('app.fichaje');
    }

    public function marcar(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();

        $registro = EmployeeTimeLog::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today]
        );

        $ahora = Carbon::now();

        switch ($request->accion) {
            case 'entrada':
                $registro->hora_entrada = $ahora;
                session(['entrada_marcada' => true]);
                break;

            case 'salida':
                $registro->hora_salida = $ahora;
                session(['salida_marcada' => true]);
                // Calcular horas trabajadas
                if ($registro->hora_entrada) {
                    $entrada = Carbon::parse($registro->hora_entrada);
                    $horasTrabajadas = $entrada->diffInMinutes($ahora) / 60;
                    $registro->horas_trabajadas = round($horasTrabajadas, 2);
                }
                break;

            case 'descanso_inicio':
                $registro->hora_inicio_descanso = $ahora;
                session(['descanso_inicio' => true]);
                break;

            case 'descanso_fin':
                $registro->hora_fin_descanso = $ahora;
                session(['descanso_fin' => true]);
                if ($registro->hora_inicio_descanso) {
                    $inicio = Carbon::parse($registro->hora_inicio_descanso);
                    $descanso = $inicio->diffInMinutes($ahora) / 60;
                    $registro->horas_descanso = round($descanso, 2);
                    $sancion = $descanso > 0.5 ? round($descanso - 0.5, 2) : 0;
                    $registro->sancion_horas = $sancion;
                }
                break;
        }

        $registro->save();

        return redirect()->route('tiempo.index');
    }
}
