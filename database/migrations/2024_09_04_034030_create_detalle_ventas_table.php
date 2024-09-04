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
        Schema::create('detalle_venta', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->decimal('costo', 10, 2);
            $table->unsignedBigInteger('id_venta');
            $table->unsignedBigInteger('id_plan_manto');
            $table->unsignedBigInteger('id_modelo');
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('id_venta')->references('id_venta')->on('venta')->onDelete('cascade');
            $table->foreign('id_plan_manto')->references('id_plan_manto')->on('plan_manto')->onDelete('cascade');
            $table->foreign('id_modelo')->references('id_modelo')->on('modelo')->onDelete('cascade');

            // Unique Key Constraints
            $table->unique('id_detalle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_venta');
    }
};
