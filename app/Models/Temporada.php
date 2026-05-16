<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'activa'
    ];

    public function partidos()
    {
        return $this->hasMany(Partido::class);
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class)
            ->withPivot('categoria', 'liga', 'grupo')
            ->withTimestamps();
    }

}
