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
        Schema::create('equipo_temporada', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipo_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('temporada_id')
                ->constrained()
                ->onDelete('cascade');

            // datos extra del equipo en esa temporada
            $table->string('categoria')->nullable();
            $table->string('liga')->nullable();
            $table->string('grupo')->nullable();

            $table->timestamps();

            $table->unique(['equipo_id', 'temporada_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_temporada');
    }
};
