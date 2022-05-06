<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Informacion extends Model
{
    protected $table = 'informaciones';
    protected $fillable = ['nombre', 'direccion', 'email','telefono','numero_tributario','numero_registro','giro','nombre_contacto','telefono_contacto','cargo'];
}
