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
        Schema::create('salas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('codigo_sala');
            $table->string('password');
            $table->integer('cantidad_retos');
            $table->string('retos_asignados')->nullable();
            $table->integer('owner');
            $table->json('ids_jugadores')->nullable();
            $table->json('jugadores')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salas');
    }
};
