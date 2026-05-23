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
        Schema::create('alimento_dieta', function (Blueprint $table) {
            $table->foreignId('dieta_id')->constrained('dietas')->cascadeOnDelete();
            $table->foreignId('alimento_id')->constrained('alimentos')->cascadeOnDelete();
            $table->string('tipo_comida', 50);
            $table->string('medidas_caseras', 100)->nullable();
            $table->decimal('peso_bruto', 20)->unsigned();
            $table->decimal('peso_neto', 20)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimento_dieta');
    }
};
