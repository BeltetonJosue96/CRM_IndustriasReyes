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
        Schema::create('modelo', function (Blueprint $table) {
            $table->id('id_modelo'); // AUTO_INCREMENT id
            $table->string('codigo', 45)->unique(); // Unique key on 'codigo'
            $table->string('descripcion', 45);
            $table->unsignedBigInteger('id_linea'); // Foreign key
            $table->primary('id_modelo'); // Primary key
            $table->foreign('id_linea')->references('id_linea')->on('linea')
                ->onDelete('cascade'); // Foreign key constraint
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelo');
    }
};
