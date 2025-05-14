<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->decimal('horas_trabajadas', 5, 2)->nullable(); // en horas
            $table->decimal('horas_descanso', 5, 2)->nullable();
            $table->decimal('sancion_horas', 5, 2)->nullable();
            $table->decimal('horas_totales_mes', 6, 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_time_logs');
    }
};
