<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar ==''){
            //listar todos los registros
        $personas = Persona::orderBy('id', 'desc')->paginate(3);

        }

        else{
            $personas = Persona::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' =>[
                'total'             => $personas->total(),
                'current_page'      => $personas->currentPage(),
                'per_page'          => $personas->perPage(),
                'last_page'         => $personas->lastPage(),
                'from'              => $personas->firstItem(),
                'to'                => $personas->lastItem(), 
            ],
            'personas'  => $personas
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //instanciar el modelo
        $persona = new Persona();
        //tomar los datos de request
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->condicion= '1';//activo


        //guardar el objeto en la tabla
        $persona->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        //buscar la categoria por el $id del request
        $persona =  Persona::findOrfail($request->id);

        //tomar los datos de request
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->condicion= '1';//activo
        

        //guardar el objeto en la tabla
        $persona->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona =  Persona::findOrfail($request->id);

        //cambiar la condicion a 0
        $persona->condicion = 0; //desactivo

        //guardar el objeto en la tabla
        $persona->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
          $persona =  Persona::findOrfail($request->id);

          //cambiar la condicion a 1
          $persona->condicion = 1; //activo
  
          //guardar el objeto en la tabla
          $persona->save();
    }
}