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
            $table->id('id_check');
            $table->date('fecha_creacion');
            $table->unsignedBigInteger('id_plan_manto');

            // Claves únicas
            $table->unique('id_check');

            // Índices
            $table->index('id_plan_manto', 'fk_checklist_plan_manto1_idx');

            // Relaciones
            $table->foreign('id_plan_manto')
                ->references('id_plan_manto')
                ->on('plan_manto')
                ->onDelete('cascade')
                ->onUpdate('cascade');

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
