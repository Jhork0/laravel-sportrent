<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    public function persona() {
    return $this->belongsTo(Persona::class, 'cedula_persona');
}

public function reservas() {
    return $this->hasMany(Reserva::class, 'cedula_persona');
}
}
