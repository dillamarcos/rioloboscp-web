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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->text('descripcion_corta');
            $table->text('descripcion_larga');
            $table->decimal('precio', 8, 2);
            $table->string('imagen')->nullable();
            $table->boolean('activo')->default(true);

            $table->foreignId('categoria_id')->constrained()->cascadeOnDelete();
            $table->foreignId('equipo_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
