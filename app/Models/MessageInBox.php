<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageInbox extends Model
{
    use HasFactory;

    protected $table = 'MessageInBox'; // si usas otro nombre, cámbialo

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'body',
        'is_read',
    ];

    // Relación con el usuario que envía el mensaje
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relación con el usuario que recibe el mensaje
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
