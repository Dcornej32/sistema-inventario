<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

use App\Proveedor;
use App\Persona;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar ==''){
            //listar todos los registros
        $personas = Proveedor::join('personas','proveedores.id','=','personas.id')
        ->select('personas.id','personas.nombre','personas.tipo_documento','personas.numero_documento','personas.direccion','personas.telefono','personas.email','proveedores.nombre_contacto','proveedores.telefono_contacto','proveedores.condicion')
        ->orderBy('personas.id', 'desc')->paginate(3);
        }

        else{
            $personas = Proveedor::join('personas','proveedores.id','=','personas.id')
            ->select('personas.id','personas.nombre','personas.tipo_documento','personas.numero_documento','personas.direccion','personas.telefono','personas.email','proveedores.nombre_contacto','proveedores.telefono_contacto','proveedores.condicion')
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

    public function selectProveedor(Request $request){
        if (!$request->ajax()) return redirect('/');

            $filtro = $request->filtro;
            $proveedores = Proveedor::join('personas','proveedores.id','=','personas.id')
            ->where('personas.nombre','like','%'. $filtro . '%')
            ->orWhere('personas.numero_documento','like','%'. $filtro . '%')
            ->select('personas.id','personas.nombre','personas.numero_documento')
            ->orderBy('personas.nombre','asc')->get();

            return ['proveedores'  => $proveedores];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try {
            DB::beginTransaction();    
        //instanciar el modelo
        $persona = new Persona();

        //tomar los datos de request
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->condicion = '1';

        //guardar el objeto en la tabla
        $persona->save();

        $proveedor = new Proveedor();
        $proveedor->nombre_contacto = $request->nombre_contacto;
        $proveedor->telefono_contacto = $request->telefono_contacto;
        $proveedor->condicion = '1';
        $proveedor->id = $persona->id;
        $proveedor->save();

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
        //Buscar primero el proveedor a mod
        $proveedor = Proveedor::findOrfail($request->id);
             
        $persona = Persona::findOrfail($proveedor->id);

        //tomar los datos de request
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->numero_documento = $request->numero_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        $persona->condicion = '1';
        $persona->save();

        $proveedor->nombre_contacto = $request->nombre_contacto;
        $proveedor->telefono_contacto = $request->telefono_contacto;
        $proveedor->condicion = '1';
        $proveedor->save();

        DB::commit();

        } catch (Exception $e) {
            DB::rolBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $proveedor =  Proveedor::findOrfail($request->id);

        //cambiar la condicion a 0
        $proveedor->condicion = 0; //desactivo

        //guardar el objeto en la tabla
        $proveedor->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
          $proveedor =  Proveedor::findOrfail($request->id);

          //cambiar la condicion a 1
          $proveedor->condicion = 1; //activo
  
          //guardar el objeto en la tabla
          $proveedor->save();
    }
}

