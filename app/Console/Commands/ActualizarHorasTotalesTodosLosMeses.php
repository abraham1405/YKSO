<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmployeeTimeLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActualizarHorasTotalesTodosLosMeses extends Command
{
    protected $signature = 'app:actualizar-horas-totales-todos-los-meses';
    protected $description = 'Actualiza la columna horas_totales_mes para cada usuario y mes';

    public function handle()
    {
        // Agrupar por usuario y mes
        $logsAgrupados = EmployeeTimeLog::select(
                'user_id',
                DB::raw('YEAR(date) as year'),
                DB::raw('MONTH(date) as month'),
                DB::raw('SUM(horas_trabajadas) as total_horas')
            )
            ->groupBy('user_id', DB::raw('YEAR(date)'), DB::raw('MONTH(date)'))
            ->get();

        foreach ($logsAgrupados as $grupo) {
            EmployeeTimeLog::where('user_id', $grupo->user_id)
                ->whereYear('date', $grupo->year)
                ->whereMonth('date', $grupo->month)
                ->update(['horas_totales_mes' => $grupo->total_horas]);

            $this->info("Actualizado: Usuario {$grupo->user_id} - {$grupo->month}/{$grupo->year} con {$grupo->total_horas} horas.");
        }

        $this->info('✅ Todos los meses actualizados correctamente.');
    }
}
