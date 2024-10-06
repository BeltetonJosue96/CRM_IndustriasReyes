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
        Schema::create('detalle_check', function (Blueprint $table) {
            $table->id('id_detalle_check')->unique();
            $table->unsignedBigInteger('id_check');
            $table->unsignedBigInteger('id_control_manto');
            $table->date('fecha_manto')->nullable();
            $table->unsignedBigInteger('id_estado');
            $table->string('observaciones', 245)->nullable();

            $table->foreign('id_check')->references('id_check')->on('checklist')->onDelete('cascade');
            $table->foreign('id_control_manto')->references('id_control_manto')->on('control_de_manto')->onDelete('cascade');
            $table->foreign('id_estado')->references('id_estado')->on('estado');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_check');
    }
};
