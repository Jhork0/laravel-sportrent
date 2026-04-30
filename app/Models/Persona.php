<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'cedula_persona';
    public $incrementing = false;
    protected $keyType = 'string';

    // AÑADE ESTA LÍNEA PARA SOLUCIONAR EL ERROR
    public $timestamps = false; 

    protected $fillable = [
        'cedula_persona',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'correo',
        'direccion',
        'telefono',
    ];
}