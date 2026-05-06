<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function alimento() {
        return $this->belongsTo(User::class, 'alimento_id', 'id');
    }
}
