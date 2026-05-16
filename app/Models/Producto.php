<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipo;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion_corta',
        'descripcion_larga',
        'precio',
        'imagen',
        'activo',
        'categoria_id',
        'equipo_id'
    ];

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
