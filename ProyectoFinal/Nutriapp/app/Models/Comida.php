<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comida extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'comidas';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'dieta_id',  // Dieta a la que pertenece la comida
        'comida',    // Tipo de comida (desayuno, almuerzo, comida, merienda, cena, suplementos)
        'receta'     // Texto libre con la receta o indicaciones de esa comida
    ];

    // Esta tabla no usa columnas created_at ni updated_at
    public $timestamps = false;

    // Relación: una comida pertenece a una dieta
    public function dieta(): BelongsTo
    {
        return $this->belongsTo(Dieta::class, 'dieta_id', 'id');
    }
}