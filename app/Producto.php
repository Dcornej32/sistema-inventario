<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
       'codigo', 'nombre', 'precio_actual', 'stock','descripcion', 'condicion','idcategorias',
    ];

    //por la relacion fk con Categoria
    public function categoria()
    {
        return $this->belongsTo('App\Categoria');
    }
}
