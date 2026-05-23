<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tipo extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'tipos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre' // Nombre del tipo de usuario (admin, profesor, alumno)
    ];

    // Relación: un tipo puede tener muchos usuarios asociados
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tipo', 'id');
    }
}