<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'cedula_persona';
    public $incrementing = false; 
    protected $keyType = 'string';

    protected $fillable = [
        'cedula_persona',
        'usuario_login',
        'contrasena',
        'estado',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token',
    ];

 
    public function getAuthPassword()
    {
        return $this->contrasena;
    }
}
