<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tipo extends Model
{
    protected $table = 'tipos';

    protected $fillable = [
        'nombre'
    ];

    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tipo', 'id');
    }
}
