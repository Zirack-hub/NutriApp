<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Alimento extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'alimentos';

    // Castea user_id a string para compatibilidad con el tipo de dato de la columna
    protected $casts = [
        'user_id' => 'string',
    ];

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'alimento',
        'pc',        // Porción comestible
        'e_100',     // Energía por 100g
        'prot_100',  // Proteínas por 100g
        'grasa_100', // Grasas totales por 100g
        'ags_100',   // Ácidos grasos saturados por 100g
        'agmi_100',  // Ácidos grasos monoinsaturados por 100g
        'agpi_100',  // Ácidos grasos poliinsaturados por 100g
        'col_100',   // Colesterol por 100g
        'hc_100',    // Hidratos de carbono por 100g
        'fibra_100', // Fibra por 100g
        'vit_c_100', // Vitamina C por 100g
        'vit_b6_100',// Vitamina B6 por 100g
        'vit_e_100', // Vitamina E por 100g
        'fe_100',    // Hierro por 100g
        'na_100',    // Sodio por 100g
        'ca_100',    // Calcio por 100g
        'k_100',     // Potasio por 100g
        'vit_d_100'  // Vitamina D por 100g
    ];

    // Oculta las marcas de tiempo en las respuestas
    protected $hidden = ['created_at', 'updated_at'];

    // Relación: un alimento pertenece a un usuario
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->onDelete('cascade');
    }

    // Relación: un alimento puede estar en muchas dietas (tabla pivot alimento_dieta)
    public function dietas(): BelongsToMany
    {
        return $this->belongsToMany(Dieta::class, 'alimento_dieta');
    }
}