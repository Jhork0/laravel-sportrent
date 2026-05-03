<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // Define el nombre correcto de la tabla
    protected $table = 'proveedor';

    // Define la clave primaria, ya que no es 'id'
    protected $primaryKey = 'cedula_propietario';

    // Si tu tabla no usa autoincremento, desactívalo
    public $incrementing = false;
    
    // Si usas tipos de datos no numéricos para la PK
    protected $keyType = 'string';

    protected $fillable = [
    'cedula_propietario',
    'usuario_login',
    'contrasena',
    'tipo_documento',
];

    // Relación con Cancha (si la tienes aquí)
    public function canchas()
{
    // A través de la tabla intermedia 'administra'
    return $this->hasManyThrough(
        Cancha::class,
        Administra::class,
        'cedula_propietario', // FK en tabla administra
        'id_cancha',          // FK en tabla cancha
        'cedula_propietario', // PK en tabla proveedor
        'id_cancha'           // PK en tabla administra
    );
}
}
