<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudSocio extends Model
{
    protected $fillable = [
        'user_id',
        'dni',
        'telefono',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
