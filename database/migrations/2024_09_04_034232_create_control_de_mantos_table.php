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
        Schema::create('control_de_manto', function (Blueprint $table) {
            $table->id('id_control_manto')->unique();
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_modelo');
            $table->unsignedBigInteger('id_plan_manto');
            $table->date('fecha_venta')->nullable();
            $table->date('proximo_manto')->nullable();
            $table->integer('contador');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente');
            $table->foreign('id_modelo')->references('id_modelo')->on('modelo');
            $table->foreign('id_plan_manto')->references('id_plan_manto')->on('plan_manto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_de_manto');
    }
};
