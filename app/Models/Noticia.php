<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Equipo;

class Noticia extends Model
{
    protected $fillable = [
        'titulo',
        'contenido',
        'imagen',
        'fecha_publicacion',
        'user_id',
        'equipo_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }
}
