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
        Schema::create('plan_manto', function (Blueprint $table) {
            $table->id('id_plan_manto');
            $table->string('nombre', 25)->unique();
            $table->string('descripcion', 45)->unique();
            $table->integer('frecuencia_mes');
            $table->timestamps();

            // Add unique constraints
            $table->unique('nombre');
            $table->unique('descripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_manto');
    }
};
