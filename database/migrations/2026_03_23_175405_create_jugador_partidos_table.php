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
        Schema::create('jugador_partidos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jugador_id')->constrained()->onDelete('cascade');
            $table->foreignId('partido_id')->constrained()->onDelete('cascade');

            $table->integer('goles')->default(0);
            $table->integer('amarillas')->default(0);
            $table->integer('rojas')->default(0);

            $table->unique(['jugador_id', 'partido_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugador_partidos');
    }
};
