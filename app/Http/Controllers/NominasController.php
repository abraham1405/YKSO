<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de tener un modelo User
use App\Models\EmployeeTimeLog;
use Carbon\Carbon;

class NominasController extends Controller
{
    public function index(Request $request)
    {
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $mesSeleccionado = $request->input('mes', date('n')); // mes actual por defecto
        $anio = date('Y'); // año actual, podrías hacerlo dinámico

        $nombreMesSeleccionado = $meses[$mesSeleccionado - 1];

        // Tarifa por hora (por ejemplo)
        $tarifaHora = 10;

        // Obtener todos los empleados
        $empleados = User::all();

        // Array para guardar la nómina calculada
        $nominas = [];

        foreach ($empleados as $empleado) {
            // Sumar horas trabajadas en el mes para ese empleado
            $totalHoras = EmployeeTimeLog::where('user_id', $empleado->id)
                ->whereYear('date', $anio)
                ->whereMonth('date', $mesSeleccionado)
                ->sum('horas_trabajadas');

            // Calcular nómina
            $salario = $totalHoras * $tarifaHora;

            $nominas[] = [
                'empleado' => $empleado,
                'horas_trabajadas' => $totalHoras,
                'salario' => $salario,
            ];
        }

        return view('admin.nominas', compact('nominas', 'mesSeleccionado', 'nombreMesSeleccionado', 'meses'));
    }


    private function calcularNomina($empleado, $mes)
    {
        // Puedes cambiar esta lógica por una tabla real con sueldos
        return 1200 + rand(0, 500); // simulamos nómina aleatoria
    }
}