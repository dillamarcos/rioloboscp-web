<?php

namespace Database\Seeders;

use App\Models\Jugador;
use App\Models\Producto;
use App\Models\Socio;
use App\Models\Temporada;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            EquipoSeeder::class,
            NoticiaSeeder::class,
            TemporadaSeeder::class,  
            PartidoSeeder::class,
            CategoriaSeeder::class,
            JugadorSeeder::class,
            ProductoSeeder::class,
        ]);

    }
}
