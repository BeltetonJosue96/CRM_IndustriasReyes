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
        Schema::create('producto', function (Blueprint $table) {
            $table->increments('id_producto'); // AUTO_INCREMENT primary key
            $table->string('nombre', 75)->unique(); // VARCHAR(75) with UNIQUE constraint
            $table->timestamps(); // Adds created_at and updated_at columns

            // Additional constraints
            $table->unique('id_producto'); // UNIQUE constraint on id_producto (though this is redundant with the primary key)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
