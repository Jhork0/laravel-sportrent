<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    public function reserva() {
    return $this->belongsTo(Reserva::class);
}
}
