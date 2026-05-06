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
            $table->id('id');
            $table->string('email', 200)->unique();
            $table->string('nombre', 100);
            $table->string('password', 255);
            $table->foreignId('tipo')->constrained('tipos');
        });

        DB::table('usuarios')->insert([
            ['id' => 1, 'email' => 'admin@admin.com', 'nombre' => 'Admin', 'password' => Hash::make('Admin'), 'tipo' => 1]
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
 