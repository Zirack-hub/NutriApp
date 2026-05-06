<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dieta extends Model
{
    protected $table = 'dietas';

    protected $fillable = [
        'user_id',
        'nombre',
        'objetivo',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function usuario(): BelongsTo
    { 
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function alimentos(): BelongsToMany
    {
        return $this->belongsToMany(Alimento::class, 'alimento_dieta')
            ->withPivot(['tipo_comida', 'medidas_caseras', 'peso_bruto', 'peso_neto', 'unidad']);
    }

    public function comidas(): HasMany
    {
        return $this->hasMany(Comida::class, 'dieta_id', 'id');
    }
}