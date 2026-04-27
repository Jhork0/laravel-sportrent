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
        Schema::create('facturas', function (Blueprint $table) {
    $table->id('id_factura');
    $table->decimal('valor_a_pagar', 10, 2);
    $table->date('fecha_pago')->nullable();
    $table->string('metodo_pago')->nullable();
    $table->timestamp('fecha_emision')->useCurrent();
    $table->string('estado')->default('pendiente');

    $table->unsignedBigInteger('id_reserva')->unique();

    $table->timestamps();

    $table->foreign('id_reserva')->references('id_reserva')->on('reservas')->cascadeOnDelete();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
