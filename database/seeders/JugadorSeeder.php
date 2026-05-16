<?php

namespace Database\Seeders;

use App\Models\Jugador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JugadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jugador::create([
            [
                'nombre' => 'Alberto',
                'apellidos' => 'García Pérez',
                'fecha_nacimiento' => '1995-04-15',
                'altura' => 1.80,
                'posicion' => 'Portero',
                'dorsal' => 1,
                'imagen' => null,
                'goles' => 0,
                'amarillas' => 2,
                'rojas' => 0,
                'equipo_id' => 1, // Riolobos C.P.
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'David',
                'apellidos' => 'López Sánchez',
                'fecha_nacimiento' => '1993-08-22',
                'altura' => 1.75,
                'posicion' => 'Defensa',
                'dorsal' => 2,
                'imagen' => null,
                'goles' => 2,
                'amarillas' => 7,
                'rojas' => 1,
                'equipo_id' => 1, // Riolobos C.P.
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nombre' => 'Miguel',
                'apellidos' => 'Fernández Gómez',
                'fecha_nacimiento' => '1990-12-05',
                'altura' => 1.85,
                'posicion' => 'Delantero',
                'dorsal' => 9,
                'imagen' => null,
                'goles' => 6,
                'amarillas' => 3,
                'rojas' => 0,
                'equipo_id' => 1, // Riolobos C.P.
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
