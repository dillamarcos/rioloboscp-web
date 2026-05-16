<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Socio;
use App\Models\Noticia;
use App\Models\SolicitudSocio;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'foto_perfil',
        'telefono',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function socio()
    {
        return $this->hasOne(Socio::class);
    }

    public function noticias()
    {
        return $this->hasMany(Noticia::class);
    }

    public function solicitudes()
    {
        return $this->hasMany(SolicitudSocio::class);
    }

    public function favoritos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class, 'favoritos');
    }

    public function carrito()
    {
        return $this->hasMany(Carrito::class);
    }

    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    public function isInstructor()
    {
        return $this->rol === 'editor';
    }
}
