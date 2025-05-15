<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de tener un modelo User
use App\Models\EmployeeTimeLog;
use App\Models\Payroll;
use Carbon\Carbon;

class NominasController extends Controller
{
    public function index(Request $request)
    {
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $anioInicio = 2025;
        $anioActual = date('Y');
        $mesActual = date('n');

        $mesSeleccionado = $request->input('mes', $mesActual);
        $anioSeleccionado = $anioActual;
        $nombreMesSeleccionado = $meses[$mesSeleccionado - 1];

        // Obtener datos del usuario autenticado desde sesión
        $sessionUser = session('user');

        if (!$sessionUser) {
            return redirect('/')->with('alert', 'Debes iniciar sesión.');
        }

        $userId = $sessionUser['id'];
        $role = $sessionUser['role'];

        // Si es admin y hay un user_id en la petición, usamos ese
        if ($role === 'admin' && $request->filled('user_id')) {
            $user = User::find($request->input('user_id'));

            if (!$user) {
                abort(404, "Usuario no encontrado");
            }
        } else {
            // Si no es admin o no hay user_id, usamos al de la sesión
            $user = User::find($userId);
        }

        $nominas = [];

        if ($role === 'admin') {
            $empleados = User::all();

            foreach ($empleados as $empleado) {
                for ($anio = $anioInicio; $anio <= $anioActual; $anio++) {
                    for ($mes = 1; $mes <= 12; $mes++) {
                        $datosNomina = $this->calcularNominaCompleta($empleado, $mes, $anio);
                        $this->guardarNomina($empleado, $mes, $anio, $datosNomina);

                        if ($anio == $anioSeleccionado && $mes == $mesSeleccionado) {
                            $nominas[] = [
                                'empleado' => $empleado,
                                'horas_normales' => $datosNomina['horas_normales'],
                                'horas_extras' => $datosNomina['horas_extras'],
                                'salario_bruto' => $datosNomina['salario_bruto'],
                                'salario_neto' => $datosNomina['salario_neto'],
                            ];
                        }
                    }
                }
            }

            return view('admin.nominas', compact('nominas', 'mesSeleccionado', 'nombreMesSeleccionado', 'meses'))
                ->with('isAdmin', true);
        }

        // Si no es admin, solo se calcula y muestra su propia nómina
        $datosNomina = $this->calcularNominaCompleta($user, $mesSeleccionado, $anioSeleccionado);
        $this->guardarNomina($user, $mesSeleccionado, $anioSeleccionado, $datosNomina);

        $nominas[] = [
            'empleado' => $user,
            'horas_normales' => $datosNomina['horas_normales'],
            'horas_extras' => $datosNomina['horas_extras'],
            'salario_bruto' => $datosNomina['salario_bruto'],
            'salario_neto' => $datosNomina['salario_neto'],
        ];

        return view('admin.nominas', compact('nominas', 'mesSeleccionado', 'nombreMesSeleccionado', 'meses'))
            ->with('isAdmin', false);
    }


    public function calcularNominaCompleta($empleado, $mes, $anio)
    {
        // Tarifas por hora (en euros)
        $valorHoraNormal = 10;
        $valorHoraExtra = 15; // 50% más que hora normal

        // Obtener registros de horas trabajadas del empleado para ese mes
        $registros = EmployeeTimeLog::where('user_id', $empleado->id)
            ->whereYear('date', $anio)
            ->whereMonth('date', $mes)
            ->get();

        // Inicializar contadores de horas normales y extras
        $horasNormales = 0;
        $horasExtras = 0;

        // Calcular horas normales y extras sumando día a día
        foreach ($registros as $registro) {
            $horasDia = $registro->horas_trabajadas;

            if ($horasDia > 8) {
                $horasNormales += 8;
                $horasExtras += $horasDia - 8;
            } else {
                $horasNormales += $horasDia;
            }
        }

        // Calcular salario bruto: horas normales y extras por su tarifa
        $pagoHorasNormales = $horasNormales * $valorHoraNormal;
        $pagoHorasExtras = $horasExtras * $valorHoraExtra;

        $salarioBruto = $pagoHorasNormales + $pagoHorasExtras;

        // Deducciones según la ley española
        $cotizacionSeguridadSocial = $salarioBruto * 0.047;  // 4.7%
        $desempleo = $salarioBruto * 0.0155;                // 1.55%
        $formacionProfesional = $salarioBruto * 0.001;       // 0.1%

        // IRPF - retenemos un 10% como ejemplo, esto depende de la situación personal
        $irpf = $salarioBruto * 0.10;

        // Suma total deducciones
        $totalDeducciones = $cotizacionSeguridadSocial + $desempleo + $formacionProfesional + $irpf;

        // Salario neto que recibirá el empleado
        $salarioNeto = $salarioBruto - $totalDeducciones;

        // Retornar los datos calculados para que puedas mostrar en vista o guardar en BD
        return [
            'horas_normales' => $horasNormales,
            'horas_extras' => $horasExtras,
            'pago_horas_normales' => $pagoHorasNormales,
            'pago_horas_extras' => $pagoHorasExtras,
            'salario_bruto' => $salarioBruto,
            'cotizacion_seguridad_social' => $cotizacionSeguridadSocial,
            'desempleo' => $desempleo,
            'formacion_profesional' => $formacionProfesional,
            'irpf' => $irpf,
            'total_deducciones' => $totalDeducciones,
            'salario_neto' => $salarioNeto,
        ];
    }

    public function guardarNomina($empleado, $mes, $anio, $datosNomina)
    {
        $mesFormateado = sprintf('%04d-%02d', $anio, $mes);

        Payroll::updateOrCreate(
            ['user_id' => $empleado->id, 'month' => $mesFormateado],
            [
                'base_salary' => $datosNomina['pago_horas_normales'],
                'plus_transport' => 0,
                'extra_pay_prorated' => 0,
                'hours_extra' => $datosNomina['horas_extras'],
                'hours_extra_payment' => $datosNomina['pago_horas_extras'],
                'total_gross' => $datosNomina['salario_bruto'],
                'ss_contribution' => $datosNomina['cotizacion_seguridad_social'],
                'unemployment' => $datosNomina['desempleo'],
                'training' => $datosNomina['formacion_profesional'],
                'irpf' => $datosNomina['irpf'],
                'total_deductions' => $datosNomina['total_deducciones'],
                'net_salary' => $datosNomina['salario_neto'],
                'month' => $mesFormateado,
            ]
        );
    }
    
    public function generarPDF($id, Request $request)
    {
        $user = User::findOrFail($id);
        $mes = $request->query('mes', now()->month);
        $anio = $request->query('anio', now()->year);

        $datos = $this->calcularNominaCompleta($user, $mes, $anio);

        $pdf = PDF::loadView('pdf.nomina', compact('user', 'mes', 'anio', 'datos'));
        return $pdf->download("nomina_{$user->name}_{$mes}_{$anio}.pdf");
    }
}