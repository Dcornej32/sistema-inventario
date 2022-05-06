<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Informacion;

class InformacionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //para realizar la busqueda
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $informaciones = Informacion::orderBy('id','desc')->paginate(3);
        }
        else {
            $informaciones = Informacion::where($criterio, 'like', '%'. $buscar .'%')->orderBy('id','desc')->paginate(3);
        }
        return [
            'pagination' => [
            'total' => $informaciones->total(), // total de registros
            'current_page' => $informaciones->currentPage(), // página actual
            'per_page'=> $informaciones->perPage(), // registros por página
            'last_page' => $informaciones->lastPage(), // ir a última página
            'from'=> $informaciones->firstItem(), // primera página
            'to'=> $informaciones->lastItem(), // última página
            ],
            'informaciones' => $informaciones
          ];
    }

    //function de store.
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        //instanciar el modelo
        $informacion = new Informacion();

        //tomar todos los datos del $request(del formulario)
        $informacion->nombre = $request->nombre;
        $informacion->direccion = $request->direccion;
        $informacion->email = $request->email;
        $informacion->telefono = $request->telefono;
        $informacion->numero_tributario = $request->numero_tributario;
        $informacion->numero_registro = $request->numero_registro;
        $informacion->giro = $request->giro;
        $informacion->nombre_contacto = $request->nombre_contacto;
        $informacion->telefono_contacto = $request->telefono_contacto;
        $informacion->cargo = $request->cargo;

        //Guardar el objeto en la tabla
        $informacion->save();
    }

     //function de actualizar.
     public function update(Request $request)
     {
         //validar si la peticion es ajax, sino redirige a la ruta raiz
         if (!$request->ajax()) return redirect('/');
 
         //busco la informacion alamacenada por el id, que se recibe en $request.
         $informacion = Informacion::findOrFail($request->id);
 
         //tomar todos los datos del $resquest(del formulario).
         $informacion->nombre = $request->nombre;
         $informacion->direccion = $request->direccion;
         $informacion->email = $request->email;
         $informacion->telefono = $request->telefono;
         $informacion->numero_tributario = $request->numero_tributario;
         $informacion->numero_registro = $request->numero_registro;
         $informacion->giro = $request->giro;
         $informacion->nombre_contacto = $request->nombre_contacto;
         $informacion->telefono_contacto = $request->telefono_contacto;
         $informacion->cargo = $request->cargo;
 
          //guardar el objeto en la tabla
         $informacion->save();
     }
}
