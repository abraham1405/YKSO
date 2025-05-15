<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeTimeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'hora_entrada',
        'hora_salida',
        'hora_inicio_descanso',
        'hora_fin_descanso',
        'horas_trabajadas',
        'horas_descanso',
        'sancion_horas',
        'horas_totales_mes',
    ];
}

