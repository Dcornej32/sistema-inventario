<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleEntrada extends Model
{
    protected $table = 'detalle_entradas';
    protected $fillable = [
        'identradas', 
        'idproductos', 
        'cantidad',
        'precio_compra'
    ];
    public $timestamps = false;
}
