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
        Schema::create('checklist', function (Blueprint $table) {
            $table->id('id_check')->unique();
            $table->date('fecha_creacion');
            $table->unsignedBigInteger('id_plan_manto');

            // Relaciones
            $table->foreign('id_plan_manto')
                ->references('id_plan_manto')
                ->on('plan_manto');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist');
    }
};
