<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionCancha extends Model
{
    public function cancha() {
    return $this->belongsTo(Cancha::class);
}

public function reserva() {
    return $this->belongsTo(Reserva::class);
}
}
