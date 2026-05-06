<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comida extends Model
{
    protected $table = 'comidas';
    protected $fillable = [
        'dieta_id',
        'comida',
        'receta'
    ];

    public function dieta(): BelongsTo
    {
        return $this->belongsTo(Dieta::class, 'dieta_id', 'id');
    }
}
