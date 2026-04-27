<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    public function usuario() {
    return $this->belongsTo(Usuario::class, 'cedula_persona');
}

public function cancha() {
    return $this->belongsTo(Cancha::class);
}

public function factura() {
    return $this->hasOne(Factura::class);
}
}
