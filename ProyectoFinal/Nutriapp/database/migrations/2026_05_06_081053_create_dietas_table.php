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
        Schema::create('dietas', function (Blueprint $table) {
            $table->id('id');
            $table->string('user_id', 50);
            $table->string('alimento_id', 50);
            $table->string('comida', 50);
            $table->timestamp('created_at')->useCurrent(); 
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();     
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dietas');
    }
};
