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
        Schema::create('recuperacion_cuentas', function (Blueprint $table) {
    $table->id('id_recuperacion');
    $table->unsignedBigInteger('id_credencial');
    $table->string('codigo');
    $table->timestamp('expiracion');
    $table->boolean('usado')->default(false);

    $table->timestamps();

    $table->foreign('id_credencial')->references('id_credencial')->on('credenciales')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recuperacion_cuentas');
    }
};
