<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dieta extends Model
{
    protected $table = 'dietas';

    protected $fillable = [
        'user_id',
        'alimento_id',
        'comida'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function usuario() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function alimentos() {
        return $this->belongsToMany(Alimento::class, 'alimento_dieta');
    }

    public function comidas(): HasMany
    {
        return $this->hasMany(Comida::class, 'dieta_id', 'id');
    }
}
