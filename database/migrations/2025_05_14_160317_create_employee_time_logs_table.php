<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employee_time_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date');
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->time('hora_inicio_descanso')->nullable();
            $table->time('hora_fin_descanso')->nullable();
            $table->time('hora_inicio_comida')->nullable();
            $table->time('hora_fin_comida')->nullable();
            $table->decimal('horas_comida', 5, 2)->nullable();
            $table->decimal('sancion_comida', 5, 2)->nullable();
            $table->decimal('horas_trabajadas', 5, 2)->nullable();
            $table->decimal('horas_descanso', 5, 2)->nullable();
            $table->decimal('sancion_horas', 5, 2)->nullable();
            $table->decimal('horas_totales_mes', 6, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Insertar fichajes de ejemplo para Abril
        $empleados = [1, 2, 3, 4, 5, 6]; // IDs de empleados
        $startDate = Carbon::create(2025, 4, 1);
        $endDate = Carbon::create(2025, 4, 30);

        // Lista de festivos (personalizable)
        $festivos = [
            '2025-04-01',
            '2025-04-25',
        ];

        $registros = [];

        foreach ($empleados as $userId) {
            $date = $startDate->copy();

            while ($date->lessThanOrEqualTo($endDate)) {
                // Saltar sábados (6), domingos (0) y festivos
                if (
                    in_array($date->dayOfWeek, [Carbon::SUNDAY, Carbon::SATURDAY]) ||
                    in_array($date->toDateString(), $festivos)
                ) {
                    $date->addDay();
                    continue;
                }

                // Horas base de trabajo 8.0h
                $horasTrabajadas = 8.0;

                // Variar horas: -1, 0, +1.5 horas con más peso a 8h
                $variacion = collect([0, 1.5])->random();

                // Asegurar que no caiga por debajo de 6 horas ni más de 9.5h
                $horasTrabajadas = max(6, min(9.5, $horasTrabajadas + $variacion));

                // Horas de descanso (descanso + comida)
                $horasDescanso = 1.25;

                // Calcular hora_entrada fija a las 08:00, salida = entrada + horas trabajadas + descanso
                $entrada = Carbon::parse('08:00:00');
                $salida = $entrada->copy()->addHours($horasTrabajadas + $horasDescanso);

                // Descanso entre 12:00 y 13:30, comida entre 14:30 y 15:30 (aproximado)
                $inicioDescanso = Carbon::parse('12:00:00');
                $finDescanso = $inicioDescanso->copy()->addMinutes(30);

                $inicioComida = Carbon::parse('14:30:00');
                $finComida = $inicioComida->copy()->addMinutes(45);

                $registros[] = [
                    'user_id' => $userId,
                    'date' => $date->toDateString(),
                    'hora_entrada' => $entrada->toTimeString(),
                    'hora_salida' => $salida->toTimeString(),
                    'hora_inicio_descanso' => $inicioDescanso->toTimeString(),
                    'hora_fin_descanso' => $finDescanso->toTimeString(),
                    'hora_inicio_comida' => $inicioComida->toTimeString(),
                    'hora_fin_comida' => $finComida->toTimeString(),
                    'horas_comida' => 0.75,
                    'sancion_comida' => 0.0,
                    'horas_trabajadas' => $horasTrabajadas,
                    'horas_descanso' => $horasDescanso,
                    'sancion_horas' => 0.0,
                    'horas_totales_mes' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $date->addDay();
            }
        }

        DB::table('employee_time_logs')->insert($registros);

        $meses = [
    [
        'mes' => 3,
        'festivos' => ['2025-03-19', '2025-03-28'], // Ejemplo de festivos en marzo
    ],
    [
        'mes' => 2,
        'festivos' => ['2025-02-28'], // Ejemplo de festivo en febrero
    ],
];

foreach ($meses as $infoMes) {
    $startDate = Carbon::create(2025, $infoMes['mes'], 1);
    $endDate = $startDate->copy()->endOfMonth();
    $festivos = $infoMes['festivos'];

    $registros = [];

    foreach ($empleados as $userId) {
        $date = $startDate->copy();

        while ($date->lessThanOrEqualTo($endDate)) {
            if (
                in_array($date->dayOfWeek, [Carbon::SUNDAY, Carbon::SATURDAY]) ||
                in_array($date->toDateString(), $festivos)
            ) {
                $date->addDay();
                continue;
            }

            $horasTrabajadas = 8.0;
            $variacion = collect([0, 1.5])->random();
            $horasTrabajadas = max(6, min(9.5, $horasTrabajadas + $variacion));
            $horasDescanso = 1.25;

            $entrada = Carbon::parse('08:00:00');
            $salida = $entrada->copy()->addHours($horasTrabajadas + $horasDescanso);

            $inicioDescanso = Carbon::parse('12:00:00');
            $finDescanso = $inicioDescanso->copy()->addMinutes(30);

            $inicioComida = Carbon::parse('14:30:00');
            $finComida = $inicioComida->copy()->addMinutes(45);

            $registros[] = [
                'user_id' => $userId,
                'date' => $date->toDateString(),
                'hora_entrada' => $entrada->toTimeString(),
                'hora_salida' => $salida->toTimeString(),
                'hora_inicio_descanso' => $inicioDescanso->toTimeString(),
                'hora_fin_descanso' => $finDescanso->toTimeString(),
                'hora_inicio_comida' => $inicioComida->toTimeString(),
                'hora_fin_comida' => $finComida->toTimeString(),
                'horas_comida' => 0.75,
                'sancion_comida' => 0.0,
                'horas_trabajadas' => $horasTrabajadas,
                'horas_descanso' => $horasDescanso,
                'sancion_horas' => 0.0,
                'horas_totales_mes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $date->addDay();
        }
    }

    DB::table('employee_time_logs')->insert($registros);
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_time_logs');
    }
};
