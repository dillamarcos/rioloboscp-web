<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorito extends Model
{
    protected $fillable = [
        'user_id',
        'producto_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
