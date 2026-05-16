<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    

    public function run()
    {
        Categoria::create(['nombre' => 'Camisetas']);
        Categoria::create(['nombre' => 'Sudaderas']);
        Categoria::create(['nombre' => 'Accesorios']);
        Categoria::create(['nombre'=> 'Pantalones']);
        Categoria::create(['nombre'=> 'Chándals']);
    }
}
