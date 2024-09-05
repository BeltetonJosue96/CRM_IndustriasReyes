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
        Schema::create('venta', function (Blueprint $table) {
            $table->id('id_venta')->unique();
            $table->date('fecha_venta');
            $table->string('descripcion', 245);
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};
