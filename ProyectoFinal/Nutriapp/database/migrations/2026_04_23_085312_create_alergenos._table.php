<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('alergenos', function (Blueprint $table) {
            $table->id('id');
            $table->string('nombre', 100);
        });

        DB::table('alergenos')->insert([
            ['id' => 1,  'nombre' => 'Gluten'],
            ['id' => 2,  'nombre' => 'Crustáceos'],
            ['id' => 3,  'nombre' => 'Huevos'],
            ['id' => 4,  'nombre' => 'Pescado'],
            ['id' => 5,  'nombre' => 'Cacahuetes'],
            ['id' => 6,  'nombre' => 'Soja'],
            ['id' => 7,  'nombre' => 'Leche'],
            ['id' => 8,  'nombre' => 'Frutos secos'],
            ['id' => 9,  'nombre' => 'Apio'],
            ['id' => 10, 'nombre' => 'Mostaza'],
            ['id' => 11, 'nombre' => 'Sésamo'],
            ['id' => 12, 'nombre' => 'Sulfitos'],
            ['id' => 13, 'nombre' => 'Altramuces'],
            ['id' => 14, 'nombre' => 'Moluscos'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_alergenos');
    }
};
