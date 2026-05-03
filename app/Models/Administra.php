<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administra extends Model
{
    // Define el nombre de la tabla
    protected $table = 'administra';

    // Si tu tabla no tiene columnas created_at y updated_at, pon esto:
    public $timestamps = false;

    // Permite asignación masiva para los campos de la tabla
    protected $fillable = ['id_admin', 'cedula_propietario', 'id_cancha'];

    // Relación con el Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'cedula_propietario', 'cedula_propietario');
    }

    // Relación con la Cancha
    public function cancha()
    {
        return $this->belongsTo(Cancha::class, 'id_cancha', 'id_cancha');
    }
}