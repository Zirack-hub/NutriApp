<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    public $timestamps = false;
    protected $fillable = [
        'email',
        'nombre',
        'password',
        'tipo'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    public function alimentos(): HasMany
    {
        return $this->hasMany(Alimento::class, 'user_id', 'id');
    }

}