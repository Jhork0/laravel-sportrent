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
        Schema::create('reservas', function (Blueprint $table) {
    $table->id('id_reserva');
    $table->date('fecha_reserva');
    $table->time('hora_inicio');
    $table->time('hora_final');
    $table->string('estado')->default('pendiente');

    $table->string('cedula_persona', 20);
    $table->unsignedBigInteger('id_cancha');

    $table->timestamps();

    $table->foreign('cedula_persona')->references('cedula_persona')->on('usuarios')->cascadeOnDelete();
    $table->foreign('id_cancha')->references('id_cancha')->on('canchas')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
