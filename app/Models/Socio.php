<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Carbon\Carbon;

class Socio extends Model
{
    protected $fillable = [
        'user_id',
        'fecha_alta',
        'fecha_fin',
        'estado',
        'cuota',
        'dni',
        'cancelado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function ($socio) {
            $socio->cuota = 10;

            if (!$socio->fecha_fin) {
                $socio->fecha_fin = Carbon::parse($socio->fecha_alta)->addYear();
            }
        });
    }
}
