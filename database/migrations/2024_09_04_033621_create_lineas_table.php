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
        Schema::create('linea', function (Blueprint $table) {
            $table->id('id_linea'); // Auto-incremental primary key
            $table->string('nombre', 100)->unique(); // Unique name
            $table->unsignedBigInteger('id_producto'); // Foreign key

            $table->foreign('id_producto')->references('id_producto')->on('producto')
                ->onDelete('cascade'); // Add foreign key constraint

            $table->timestamps(); // Optional: created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea');
    }
};
