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
        Schema::create('comidas', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('dieta_id')->constrained('dietas');
            $table->string('comida', 50);
            $table->string('receta', 1500);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comidas');
    }
};
