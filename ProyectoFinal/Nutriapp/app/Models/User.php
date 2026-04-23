<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'EMAIL',
        'NOMBRE',
        'CONTRASENA',
        'TIPO'
    ];

    protected $hidden = ['CONTRASENA'];

    public function alimentos(): HasMany {
        return $this->hasMany(Alimento::class, 'ID_USUARIO', 'ID');
    }
}
