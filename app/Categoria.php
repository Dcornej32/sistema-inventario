<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //para asignar valores en masa
    protected $fillable = ['nombre', 'descripcion', 'condicion'];
}
