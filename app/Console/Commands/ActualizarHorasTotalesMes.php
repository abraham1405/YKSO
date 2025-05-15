<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EmployeeTimeLog;
use \Carbon\Carbon;

class ActualizarHorasTotalesMes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:actualizar-horas-totales-mes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calcula y actualiza las horas totales del mes para cada usuario';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando cálculo de horas totales del mes...');

        $inicioMes = Carbon::now()->startOfMonth()->toDateString();
        $finMes = Carbon::now()->endOfMonth()->toDateString();

        $users = EmployeeTimeLog::select('user_id')->distinct()->pluck('user_id');

        foreach ($users as $userId) {
            $totalHoras = EmployeeTimeLog::where('user_id', $userId)
                ->whereBetween('date', [$inicioMes, $finMes])
                ->sum('horas_trabajadas');

            EmployeeTimeLog::where('user_id', $userId)
                ->whereBetween('date', [$inicioMes, $finMes])
                ->update(['horas_totales_mes' => $totalHoras]);

            $this->info("Usuario $userId actualizado con total horas: $totalHoras");
        }

        $this->info('Proceso terminado con éxito.');
    }
}
