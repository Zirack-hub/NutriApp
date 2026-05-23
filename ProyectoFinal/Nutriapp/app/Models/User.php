<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

// Extiende Authenticatable para que Laravel gestione la autenticación sobre este modelo
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nombre de la tabla en la base de datos
    protected $table = 'usuarios';

    // Esta tabla no usa columnas created_at ni updated_at
    public $timestamps = false;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'email',
        'nombre',
        'password',
        'tipo',                 // Rol del usuario: 1 = admin, 2 = profesor, 3 = alumno
        'must_change_password', // Indica si el usuario debe cambiar su contraseña en el próximo login
    ];

    // Oculta estos campos en las respuestas para no exponer datos sensibles
    protected $hidden = [
        'password',
        'remember_token'
    ];

    // Relación: un usuario puede tener muchos alimentos registrados
    public function alimentos(): HasMany
    {
        return $this->hasMany(Alimento::class, 'user_id', 'id');
    }

    // Relación: un usuario puede tener muchas dietas
    public function dietas(): HasMany
    {
        return $this->hasMany(Dieta::class, 'user_id', 'id');
    }

    // Relación: un usuario tiene un tipo de rol asociado (admin, profesor o alumno)
    public function tipoRelacion(): HasOne
    {
        return $this->hasOne(Tipo::class, 'id', 'tipo');
    }
}