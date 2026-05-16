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
        Schema::create('jugadors', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->decimal('altura', 4, 2);
            $table->enum('posicion', [
                'portero',
                'cierre',
                'ala',
                'delantero'
            ]);
            $table->integer('dorsal');
            $table->string('imagen')->nullable();

            $table->integer('goles')->default(0);
            $table->integer('amarillas')->default(0);
            $table->integer('rojas')->default(0);

            $table->foreignId('equipo_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugadors');
    }
};
