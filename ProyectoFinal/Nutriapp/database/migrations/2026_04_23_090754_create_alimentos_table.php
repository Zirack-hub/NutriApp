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
            $table->id('ID');
            $table->string('ID_USUARIO', 50);
            $table->string('ALIMENTO', 255);
            $table->float('PC_E_100',10,2);
            $table->float('PROT_100',10,2);
            $table->float('GRASA_100',10,2);
            $table->float('AGS_100',10,2);
            $table->float('AGMI_100',10,2);
            $table->float('AGPI_100',10,2);
            $table->float('COL_100',10,2);
            $table->float('HC_100',10,2);
            $table->float('FIBRA_100',10,2);
            $table->float('VIT_C_100',10,2);
            $table->float('VIT_B6_100',10,2);
            $table->float('VIT_E_100',10,2);
            $table->float('FE_100',10,2);
            $table->float('NA_100',10,2);
            $table->float('CA_100',10,2);
            $table->float('K_100',10,2);
            $table->float('VIT_D_100',10,2);
            $table->timestamp('FECHA_CREACION')->useCurrent(); 
            $table->timestamp('FECHA_ACTUALIZACION')->useCurrent()->useCurrentOnUpdate();        
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
