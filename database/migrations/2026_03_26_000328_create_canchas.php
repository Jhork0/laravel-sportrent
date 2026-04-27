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
        Schema::create('canchas', function (Blueprint $table) {
    $table->id('id_cancha');
    $table->string('nombre_cancha');
    $table->string('tipo_cancha');
    $table->text('descripcion');
    $table->decimal('valor_hora', 10, 2);
    $table->time('hora_apertura');
    $table->time('hora_cierre');
    $table->string('estado')->default('disponible');
    $table->string('foto_url')->nullable();
    $table->string('direccion_cancha');
    $table->string('cedula_propietario', 20);

    $table->timestamps();

    $table->foreign('cedula_propietario')->references('cedula_propietario')->on('proveedores')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canchas');
    }
};
