<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    protected $fillable = [
        'USUARIO',
        'ALIMENTO',
        'PC_E_100',
        'PROT_100',
        'GRASA_100',
        'AGS_100',
        'AGMI_100',
        'AGPI_100',
        'COL_100',
        'HC_100',
        'FIBRA_100',
        'VIT_C_100',
        'VIT_B6_100',
        'VIT_E_100',
        'FE_100',
        'NA_100',
        'CA_100',
        'K_100',
        'VIT_D_100'
    ];

    protected $hidden = ['CREADO_EN', 'ACTUALIZADO_EN'];

    public function usuario() {
        return $this->belongsTo(User::class, 'ID_USUARIO', 'ID');
    }
}
