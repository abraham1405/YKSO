<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'base_salary',
        'plus_transport',
        'extra_pay_prorated',
        'hours_extra',
        'hours_extra_payment',
        'total_gross',
        'ss_contribution',
        'unemployment',
        'training',
        'irpf',
        'total_deductions',
        'net_salary',
        'month',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}