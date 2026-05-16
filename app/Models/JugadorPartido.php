<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jugador;
use App\Models\Partido;

class JugadorPartido extends Model
{
    protected $fillable = [
        'jugador_id',
        'partido_id',
        'goles',
        'amarillas',
        'rojas',
    ];

    protected $table = 'jugador_partidos';

    public function jugador()
    {
        return $this->belongsTo(Jugador::class);
    }

    public function partido()
    {
        return $this->belongsTo(Partido::class);
    }
}
