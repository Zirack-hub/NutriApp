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
        Schema::create('alimentos', function (Blueprint $table) {
            $table->id('id');
            $table->string('user_id', 50);
            $table->string('alimento', 255);
            $table->float('pc_e_100',10,2);
            $table->float('prot_100',10,2);
            $table->float('grasa_100',10,2);
            $table->float('ags_100',10,2);
            $table->float('agmi_100',10,2);
            $table->float('agpi_100',10,2);
            $table->float('col_100',10,2);
            $table->float('hc_100',10,2);
            $table->float('fibra_100',10,2);
            $table->float('vit_c_100',10,2);
            $table->float('vit_b6_100',10,2);
            $table->float('vit_e_100',10,2);
            $table->float('fe_100',10,2);
            $table->float('na_100',10,2);
            $table->float('ca_100',10,2);
            $table->float('k_100',10,2);
            $table->float('vit_d_100',10,2);
            $table->timestamp('fecha_creacion')->useCurrent(); 
            $table->timestamp('fecha_actualizacion')->useCurrent()->useCurrentOnUpdate();        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};
