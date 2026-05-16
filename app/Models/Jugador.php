<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipo;
use App\Models\Partido;

class Jugador extends Model
{
    protected $fillable = [
        'equipo_id',
        'nombre',
        'apellidos',
        'fecha_nacimiento',
        'posicion',
        'altura',
        'dorsal',
        'imagen',
        'goles',
        'amarillas',
        'rojas',
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function partidos()
    {
        return $this->belongsToMany(Partido::class, 'jugador_partidos')
            ->withPivot('goles', 'amarillas', 'rojas')
            ->withTimestamps();
    }
    
}
