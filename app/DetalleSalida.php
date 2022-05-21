<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleSalida extends Model
{
    protected $table = 'detalle_salidas';
    protected $fillable = [
        'idsalidas',
        'idproductos',
        'cantidad',
        'precio_actual',
    ]; 
    public $timestamps = false;
}
