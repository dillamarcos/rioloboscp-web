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
        Schema::create('partidos', function (Blueprint $table) {
            $table->id();

            $table->date('fecha');
            $table->integer('jornada');

            $table->integer('goles_local')->default(0);
            $table->integer('goles_visitante')->default(0);

            $table->string('campo')->nullable();

            $table->foreignId('temporada_id')->constrained('temporadas')->onDelete('cascade');
            $table->foreignId('equipo_local_id')->constrained('equipos')->onDelete('cascade');
            $table->foreignId('equipo_visitante_id')->constrained('equipos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidos');
    }
};
