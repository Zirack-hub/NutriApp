<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimento extends Model
{
    protected $table = 'alimentos';
    
    protected $fillable = [
        'user_id',
        'alimento',
        'pc_e_100',
        'prot_100',
        'grasa_100',
        'ags_100',
        'agmi_100',
        'agpi_100',
        'col_100',
        'hc_100',
        'fibra_100',
        'vit_c_100',
        'vit_b6_100',
        'vit_e_100',
        'fe_100',
        'na_100',
        'ca_100',
        'k_100',
        'vit_d_100'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function usuario() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dietas() {
        return $this->belongsToMany(Dieta::class, 'alimento_dieta');
    }
}
