<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Noticia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $equipo = Equipo::first();

        Noticia::create([
            'titulo' => 'Comienza la temporada',
            'contenido' => 'El Riolobos CP inicia una nueva temporada llena de ilusión.',
            'fecha_publicacion' => now(),
            'equipo_id' => $equipo->id,
            'user_id' => 1
        ]);

        Noticia::create([
            'titulo' => 'Victoria importante',
            'contenido' => 'Gran victoria del equipo en casa.',
            'fecha_publicacion' => now()->subDays(2),
            'equipo_id' => $equipo->id,
            'user_id' => 1
        ]);
    }
}
