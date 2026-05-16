<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temporadas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: 2025/26
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->boolean('activa')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temporadas');
    }
};
