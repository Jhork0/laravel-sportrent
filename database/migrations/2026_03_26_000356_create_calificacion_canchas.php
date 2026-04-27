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
        Schema::create('calificacion_canchas', function (Blueprint $table) {
    $table->id('id_calificacion');
    $table->integer('puntuacion');
    $table->text('comentario')->nullable();

    $table->unsignedBigInteger('id_reserva');
    $table->unsignedBigInteger('id_cancha');
    $table->string('cedula_cliente', 20);

    $table->timestamp('fecha')->useCurrent();

    $table->unique(['id_reserva', 'cedula_cliente']);

    $table->foreign('id_reserva')->references('id_reserva')->on('reservas')->cascadeOnDelete();
    $table->foreign('id_cancha')->references('id_cancha')->on('canchas')->cascadeOnDelete();
    $table->foreign('cedula_cliente')->references('cedula_persona')->on('usuarios')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacion_canchas');
    }
};
