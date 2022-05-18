<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Salida;
use App\DetalleSalida;
use Exception;


class SalidaController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $salidas = Salida::join('personas','salidas.idclientes','=','personas.id')
            ->join('users','salidas.idusuarios','=','users.id')
            ->select('salidas.id','salidas.fecha_salida','salidas.total',
            'salidas.condicion','personas.nombre','users.usuario')
            ->orderBy('salidas.id', 'desc')->paginate(3);
        }
        else{
            $salidas = Salida::join('personas','salidas.idclientes','=','personas.id')
            ->join('users','salidas.idusuarios','=','users.id')
            ->select('salidas.id','salidas.fecha_salida','salidas.total',
            'salidas.condicion','personas.nombre','users.usuario')
            ->where('salidas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('salidas.id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $salidas->total(),
                'current_page' => $salidas->currentPage(),
                'per_page'     => $salidas->perPage(),
                'last_page'    => $salidas->lastPage(),
                'from'         => $salidas->firstItem(),
                'to'           => $salidas->lastItem(),
            ],
            'salidas' => $salidas
        ];
    }
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $salida = Salida::join('personas','salidas.idclientes','=','personas.id')
        ->join('users','salidas.idusuarios','=','users.id')
        ->select('salidas.id','salidas.fecha_salida','salidas.total','salidas.condicion','personas.nombre','users.usuario')
        ->where('salidas.id','=',$id)
        ->orderBy('salidas.id', 'desc')->take(1)->get();
        
        return ['salida' => $salida];
    }



    public function obtenerDetalle(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
        $detalles = DetalleSalida::join('productos','detalle_salidas.idproductos','=','productos.id')
        ->select('detalle_salidas.cantidad','detalle_salidas.precio_actual','productos.nombre as producto')
        ->where('detalle_salidas.idsalidas','=',$id)
        ->orderBy('detalle_salidas.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            $mytime= Carbon::now('America/El_Salvador');

            $salida = new Salida();
            $salida->idclientes = $request->idclientes;
            $salida->idusuarios = \Auth::user()->id;
            $salida->fecha_salida = $mytime->toDateString();
            $salida->total = $request->total;
            $salida->condicion = '1';
            $salida->save();

            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos

            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleSalida();
                $detalle->idsalidas = $salida->id;
                $detalle->idproductos = $det['idproductos'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio_actual = $det['precio_actual'];          
                $detalle->save();
            }           

            DB::commit();
            return [
                'id' => $salida->id
            ];
        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $salida = Salida::findOrFail($request->id);
        $salida->condicion = '0';
        $salida->save();
    }
    
}
