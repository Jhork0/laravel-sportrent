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
       Schema::create('usuarios', function (Blueprint $table) {
    $table->string('cedula_persona', 20)->primary();
    $table->string('estado')->default('activo');

    $table->unsignedBigInteger('id_credencial');

    $table->timestamps();

    $table->foreign('cedula_persona')->references('cedula_persona')->on('personas')->cascadeOnDelete();
    $table->foreign('id_credencial')->references('id_credencial')->on('credenciales')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
