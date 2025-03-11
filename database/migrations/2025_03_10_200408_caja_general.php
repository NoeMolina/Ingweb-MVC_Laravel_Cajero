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
        Schema::create('caja_general', function (Blueprint $table) {
            $table->integer('Tienda');
            $table->integer('Denominacion');
            $table->integer('cant_disponible');

            $table->primary(['Tienda', 'Denominacion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caja_general');
    }
};
