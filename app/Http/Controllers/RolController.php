<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $roles = Rol::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $roles = Rol::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page'     => $roles->perPage(),
                'last_page'    => $roles->lastPage(),
                'from'         => $roles->firstItem(),
                'to'           => $roles->lastItem(),
            ],
            'roles' => $roles
        ];
    }
    public function selectRol(Request $request)
    {
        $roles = Rol::where('condicion', '=', '1')
        ->select('id','nombre')
        ->orderBy('nombre', 'asc')->get();

        return ['roles' => $roles];
    } 

    public function store(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
        //instanciar el modelo
        $roles = new Rol();

        //tomar los datos de request
        $roles->nombre = $request->nombre;
        $roles->descripcion = $request->descripcion;
        $roles->condicion = 1; //activo

        //guardar el objeto en la tabla
        $roles->save();
    }
    public function update(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
        //buscar los roles por el $id del request
        $roles =  Rol::findOrfail($request->id);

        //tomar los datos de request
        $roles->nombre = $request->nombre;
        $roles->descripcion = $request->descripcion;
        $roles->condicion = 1; //activo

        //guardar el objeto en la tabla
        $roles->save();
    }
    public function desactivar(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
        //buscar los roles por el $id del request
        $roles =  Rol::findOrfail($request->id);

        //cambiar la condicion a 0
        $roles->condicion = 0; //desactivo

        //guardar el objeto en la tabla
        $roles->save();
    
    }
    public function activar(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
          //buscar los roles por el $id del request
          $roles =  Rol::findOrfail($request->id);

          //cambiar la condicion a 1
          $roles->condicion = 1; //activo
  
          //guardar el objeto en la tabla
          $roles->save();
    }
}
