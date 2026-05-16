<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Producto::create([
            'nombre' => 'Camiseta Oficial 2025/26',
            'descripcion_corta' => 'Camiseta oficial del Riolobos C.P. para la temporada 2025/26.',
            'descripcion_larga' => 'Camiseta oficial del Riolobos C.P. para la temporada 2025/26, fabricada con materiales de alta calidad para un rendimiento óptimo en el campo.',
            'precio' => 35.00,
            'imagen' => null,
            'activo' => true,
            'categoria_id' => 1,
            'equipo_id' => 1,
        ]);

        Producto::create([
            'nombre' => 'Balón Oficial Riolobos C.P.',
            'descripcion_corta' => 'Balón oficial del Riolobos C.P., ideal para entrenamientos y partidos.',
            'descripcion_larga' => 'Balón oficial del Riolobos C.P., diseñado para ofrecer un excelente control y durabilidad tanto en entrenamientos como en partidos.',
            'precio' => 25.00,
            'imagen' => null,
            'activo' => true,
            'categoria_id' => 3,
            'equipo_id' => 1,
        ]);

        Producto::create([
            'nombre' => 'Pantalón de Entrenamiento',
            'descripcion_corta' => 'Pantalón de entrenamiento oficial del Riolobos C.P., cómodo y resistente.',
            'descripcion_larga' => 'Pantalón de entrenamiento oficial del Riolobos C.P., confeccionado con materiales de alta calidad para garantizar comodidad y durabilidad durante los entrenamientos.',
            'precio' => 20.00,
            'imagen' => null,
            'activo' => true,
            'categoria_id' => 4,
            'equipo_id' => 1,
        ]);

    }
}
