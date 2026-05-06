<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    protected $table = 'comidas';
    protected $fillable = [
        'dieta_id',
        'comida',
        'receta'
    ];

    public function dieta() {
        return $this->belongsTo(Dieta::class, 'dieta_id', 'id');
    }
}
