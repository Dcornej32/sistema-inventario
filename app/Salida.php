<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $fillable = [
        'idclientes',
        'idusuarios',
        'fecha_salida',
        'total',
        'condicion'
    ];  
  
}