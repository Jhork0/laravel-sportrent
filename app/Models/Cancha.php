<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    protected $table = 'cancha';
    protected $primaryKey = 'id_cancha';

    protected $fillable = [
        'nombre_cancha',
        'tipo_cancha',
        'descripcion',
        'valor_hora',
        'hora_apertura',
        'hora_cierre',
        'estado',
        'foto',
        'direccion_cancha'
    ];
}
