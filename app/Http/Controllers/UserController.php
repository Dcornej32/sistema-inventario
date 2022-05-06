<?php

namespace App\Http\Controllers;
use Exception;
use App\User;
use App\Persona;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
       if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar ==''){
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipo_documento','personas.numero_documento','personas.direccion','personas.telefono','personas.email','users.usuario','users.password','users.condicion','users.idrol','roles.nombre as rol')
            ->orderBy('personas.id', 'desc')->paginate(3);
            }

        else{
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipo_documento','personas.numero_documento','personas.direccion','personas.telefono','personas.email','users.usuario','users.password','users.condicion','users.idrol','roles.nombre as rol')
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(3);
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
        
        try {
        DB::beginTransaction();    
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->condicion = '1';
        $persona->save();

        $user = new User();
        $user->usuario = $request->usuario;
        $user->password = bcrypt($request->password);
        $user->condicion = '1';
        $user->idrol = $request->idrol;

        $user->id = $persona->id;
        $user->save();

        DB::commit();

        } catch (Exception $e) {
            DB::rolBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try {
            DB::beginTransaction();
        //Buscar primero el user a mod
        $user = User::findOrfail($request->id);
             
        $persona = Persona::findOrfail($user->id);

        //tomar los datos de request
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->condicion = '1';
        $persona->save();

        $user->usuario = $request->usuario;
        $user->password = bcrypt($request->password);
        $user->condicion = '1';
        $user->idrol = $request->idrol;
        $user->save();

        DB::commit();

        } catch (Exception $e) {
            DB::rolBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user =  User::findOrfail($request->id);

        //cambiar la condicion a 0
        $user->condicion = 0; //desactivo

        //guardar el objeto en la tabla
        $user->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
          $user =  User::findOrfail($request->id);

          //cambiar la condicion a 1
          $user->condicion = 1; //activo
  
          //guardar el objeto en la tabla
          $user->save();
    }
}
