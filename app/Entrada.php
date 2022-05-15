<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    protected $fillable = [
        'idproveedores', 
        'idusuarios', 
        'fecha_entrada',
        'total_compra',
        'condicion'
    ];

    
   

    //por la relacion fk con Usuarios
    public function usuario(){
        return $this->belongsTo('App\User');
    }

     //por la relacion fk con Proveedores
     public function proveedor() {
         return $this->belongsTo('App\Proveedor');
     }
}
