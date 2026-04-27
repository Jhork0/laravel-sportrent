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
        Schema::create('proveedores', function (Blueprint $table) {
    $table->string('cedula_propietario', 20)->primary();
    $table->string('tipo_documento');
    $table->unsignedBigInteger('id_credencial');

    $table->timestamps();

    $table->foreign('cedula_propietario')->references('cedula_persona')->on('personas')->cascadeOnDelete();
    $table->foreign('id_credencial')->references('id_credencial')->on('credenciales')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
