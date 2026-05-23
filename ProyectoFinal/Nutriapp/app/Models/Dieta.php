<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dieta extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'dietas';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',   // Usuario propietario de la dieta
        'nombre',    // Nombre descriptivo de la dieta
        'objetivo',  // Objetivo calórico diario en kcal
    ];

    // Oculta las marcas de tiempo en las respuestas
    protected $hidden = ['created_at', 'updated_at'];

    // Relación: una dieta pertenece a un usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relación: una dieta puede tener muchos alimentos (tabla pivot alimento_dieta).
    // Se incluyen los campos extra del pivot: tipo de comida, pesos y medidas caseras
    public function alimentos(): BelongsToMany
    {
        return $this->belongsToMany(Alimento::class, 'alimento_dieta')
            ->withPivot(['tipo_comida', 'medidas_caseras', 'peso_bruto', 'peso_neto']);
    }

    // Relación: una dieta puede tener muchas comidas (desayuno, almuerzo, comida, merienda, cena, suplementos)
    public function comidas(): HasMany
    {
        return $this->hasMany(Comida::class, 'dieta_id', 'id');
    }
}