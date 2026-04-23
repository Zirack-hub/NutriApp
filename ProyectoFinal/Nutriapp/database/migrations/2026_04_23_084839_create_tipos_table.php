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
            $table->id('ID');
            $table->string('NOMBRE',100);
        });
        
        DB::table('tipos')->insert([
            ['ID' => 1, 'NOMBRE' => 'Admin'],
            ['ID' => 2, 'NOMBRE' => 'Profesor'],
            ['ID' => 3, 'NOMBRE' => 'Alumno']
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
