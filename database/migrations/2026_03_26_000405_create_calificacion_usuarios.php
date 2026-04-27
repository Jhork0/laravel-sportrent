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
        Schema::create('calificacion_usuarios', function (Blueprint $table) {
    $table->id('id_calificacion');
    $table->integer('puntuacion');
    $table->text('comentario')->nullable();

    $table->unsignedBigInteger('id_reserva');
    $table->string('cedula_usuario', 20);
    $table->string('cedula_propietario', 20);

    $table->timestamp('fecha')->useCurrent();

    $table->unique(['id_reserva', 'cedula_propietario']);

    $table->foreign('id_reserva')->references('id_reserva')->on('reservas')->cascadeOnDelete();
    $table->foreign('cedula_usuario')->references('cedula_persona')->on('usuarios')->cascadeOnDelete();
    $table->foreign('cedula_propietario')->references('cedula_propietario')->on('proveedores')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacion_usuarios');
    }
};
