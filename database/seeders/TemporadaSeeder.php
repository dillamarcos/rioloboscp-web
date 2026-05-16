<?php

namespace Database\Seeders;

use App\Models\Temporada;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemporadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Temporada::create([
            'nombre' => '2025/26',
            'fecha_inicio' => '2025-09-01',
            'fecha_fin' => '2026-06-15',
            'activa' => true,
        ]);
        Temporada::create([
            'nombre' => '2024/25',
            'fecha_inicio' => '2024-09-01',
            'fecha_fin' => '2025-06-15',
            'activa' => false,
        ]);
    }
}
