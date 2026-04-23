<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('ID');
            $table->string('EMAIL', 200)->unique();
            $table->string('NOMBRE', 100);
            $table->string('CONTRASENA', 255);
            $table->integer('TIPO');
        });

        DB::table('usuarios')->insert([
            ['ID' => 1, 'EMAIL' => 'admin@admin.com', 'NOMBRE' => 'Admin', 'CONTRASENA' => Hash::make('Admin'), 'TIPO' => 0]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_usuarios');
    }
};
