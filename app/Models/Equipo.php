<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Jugador;
use App\Models\Partido;
use App\Models\EstadisticaEquipo;
use App\Models\Producto;
use App\Models\Noticia;
use App\Models\Temporada;

class Equipo extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'localizacion',
        'entrenador',
        'escudo',
    ];

    public function jugadores()
    {
        return $this->hasMany(Jugador::class);
    }

    public function partidosLocal()
    {
        return $this->hasMany(Partido::class, 'equipo_local_id');
    }

    public function partidosVisitante()
    {
        return $this->hasMany(Partido::class, 'equipo_visitante_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }

    public function temporadas()
    {
        return $this->belongsToMany(Temporada::class)
            ->withPivot(['categoria', 'liga', 'grupo'])
            ->withTimestamps();
    }
}
