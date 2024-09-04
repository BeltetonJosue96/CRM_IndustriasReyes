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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nombre', 145);
            $table->string('apellidos', 145);
            $table->string('identificacion', 25)->unique();
            $table->string('telefono', 45);
            $table->unsignedBigInteger('id_empresa')->nullable();
            $table->string('cargo', 45)->nullable();
            $table->string('direccion', 245);
            $table->string('referencia', 245);
            $table->string('municipio', 45);
            $table->unsignedBigInteger('id_departamento');

            $table->foreign('id_empresa')
                ->references('id_empresa')
                ->on('empresa')
                ->onDelete('set null');

            $table->foreign('id_departamento')
                ->references('id_departamento')
                ->on('departamento')
                ->onDelete('cascade');

            $table->unique('id_cliente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
