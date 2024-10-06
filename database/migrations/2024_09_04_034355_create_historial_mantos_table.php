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
        Schema::create('historial_manto', function (Blueprint $table) {
            $table->id('id_historial_manto')->unique();
            $table->unsignedBigInteger('id_detalle_check')->nullable();
            $table->unsignedBigInteger('id_control_manto')->nullable();
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->date('fecha_programada')->nullable();
            $table->integer('contador')->nullable();
            $table->string('observaciones', 245)->nullable();

            // Definición de llaves foráneas
            $table->foreign('id_detalle_check')->references('id_detalle_check')->on('detalle_check')->onDelete('set null');
            $table->foreign('id_control_manto')->references('id_control_manto')->on('control_de_manto')->onDelete('set null');
            $table->foreign('id_estado')->references('id_estado')->on('estado')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_manto');
    }
};
