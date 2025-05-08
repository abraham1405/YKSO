<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    use HasFactory;

    protected $table = 'user_data';

    protected $fillable = [
        'user_id',
        'birth_date',
        'address',
        'company_assigned',
        'entry_date',          
        'emergency_contact'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}