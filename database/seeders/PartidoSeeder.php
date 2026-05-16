<?php

namespace Database\Seeders;

use App\Models\Equipo;
use App\Models\Partido;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $local = Equipo::where('nombre', 'Riolobos C.P.')->first();
        $visitante = Equipo::where('nombre', 'Losar Futsal')->first();

        Partido::create([
            'fecha' => now()->subDays(10),
            'jornada' => 1,
            'goles_local' => 3,
            'goles_visitante' => 1,
            'campo' => 'Pabellón Municipal de Riolobos',
            'temporada_id' => 1, // Temporada 2025/26
            'equipo_local_id' => $local->id,
            'equipo_visitante_id' => $visitante->id
        ]);

        Partido::create([
            'fecha' => now()->addDays(5),
            'jornada' => 2,
            'goles_local' => 0,
            'goles_visitante' => 0,
            'campo' => 'Fuera',
            'temporada_id' => 1, // Temporada 2025/26
            'equipo_local_id' => $local->id,
            'equipo_visitante_id' => $visitante->id
        ]);
    }
}
