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
        Schema::create('socios', function (Blueprint $table) {
            $table->id();

            $table->date('fecha_alta');
            $table->date('fecha_fin')->nullable();
            $table->string('dni')->unique();

            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->boolean('cancelado')->default(false);

            $table->decimal('cuota', 8, 2);

            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
