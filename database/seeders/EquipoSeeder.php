<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Partido;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Equipo::create([
            'nombre' => 'Riolobos C.P.',
            'descripcion' => 'Equipo de fútbol sala',
            'localizacion' => 'Riolobos',
            'entrenador' => 'Segundo Rodríguez Granado',
            'escudo' => 'images/escudo_nav.png'
        ]);

        Equipo::create([
            'nombre' => 'Losar Futsal',
            'descripcion' => 'Equipo de fútbol sala',
            'localizacion' => 'Losar de la Vera',
            'entrenador' => 'Sin asignar',
            'escudo' => 'images/escudo_losar.png'
        ]);
    }
}
