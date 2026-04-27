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
        Schema::create('tipos', function (Blueprint $table) {
            $table->id('id');
            $table->string('nombre',100);
        });
        
        DB::table('tipos')->insert([
            ['id' => 1, 'nombre' => 'Admin'],
            ['id' => 2, 'nombre' => 'Profesor'],
            ['id' => 3, 'nombre' => 'Alumno']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_tipos');
    }
};
