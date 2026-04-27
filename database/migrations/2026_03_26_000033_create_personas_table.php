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
        Schema::create('personas', function (Blueprint $table) {
    $table->string('cedula_persona', 20)->primary();
    $table->string('primer_nombre', 50);
    $table->string('segundo_nombre', 50)->nullable();
    $table->string('primer_apellido', 50);
    $table->string('segundo_apellido', 50);
    $table->string('correo', 100)->unique();
    $table->string('direccion', 100);
    $table->string('telefono', 20);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
