<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipo;
use App\Models\Jugador;

class Partido extends Model
{
    protected $fillable = [
        'equipo_local_id',
        'equipo_visitante_id',
        'fecha',
        'goles_local',
        'goles_visitante',
        'jornada',
        'campo',
        'temporada_id',
    ];

    public function equipoLocal()
    {
        return $this->belongsTo(Equipo::class, 'equipo_local_id');
    }

    public function equipoVisitante()
    {
        return $this->belongsTo(Equipo::class, 'equipo_visitante_id');
    }

    public function jugadores()
    {
        return $this->belongsToMany(Jugador::class, 'jugador_partidos')
            ->withPivot('goles', 'amarillas', 'rojas')
            ->withTimestamps();
    }

    public function temporada()
    {
        return $this->belongsTo(Temporada::class);
    }

    public function getEstaJugadoAttribute()
    {
        return \Carbon\Carbon::parse($this->fecha)->lte(now());
    }
}
