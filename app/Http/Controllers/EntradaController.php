<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Entrada;
use App\DetalleEntrada;
use Exception;
use Carbon\Carbon;
use APP\User;
use App\Notifications\NotifyAdmin;


class EntradaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $entradas =Entrada::join('personas','entradas.idproveedores','=','personas.id')
            ->join('users','entradas.idusuarios','=','users.id')
            ->select('entradas.id','entradas.fecha_entrada','entradas.total_compra',
            'entradas.condicion',
            'personas.nombre','users.usuario')
            ->orderBy('entradas.id', 'desc')->paginate(3);
        }
        else{
            $entradas =Entrada::join('personas','entradas.idproveedores','=','personas.id')
            ->join('users','entradas.idusuarios','=','users.id')
            ->select('entradas.id','entradas.fecha_entrada','entradas.total_compra',
            'entradas.condicion',
            'personas.nombre','users.usuario')     
            ->where('entradas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('entradas.id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $entradas->total(),
                'current_page' => $entradas->currentPage(),
                'per_page'     => $entradas->perPage(),
                'last_page'    => $entradas->lastPage(),
                'from'         => $entradas->firstItem(),
                'to'           => $entradas->lastItem(),
            ],
            'entradas' => $entradas
        ];
    }

    public function obtenerCabecera(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
            $entrada = Entrada::join('personas','entradas.idproveedores','=','personas.id')
            ->join('users','entradas.idusuarios','=','users.id')
            ->select('entradas.id','entradas.fecha_entrada','entradas.total_compra',
            'entradas.condicion',
            'personas.nombre','users.usuario')
            ->where('entradas.id', '=',$id)
            ->orderBy('entradas.id', 'desc')->take(1)->get();

        return ['entrada' => $entrada];
    }

    public function obtenerDetalle(Request $request) {
        if (!$request->ajax()) return redirect('/');

        $id = $request->id;
            $detalles =DetalleEntrada::join('productos','detalle_entradas.idproductos','=','productos.id')
            ->select('detalle_entradas.cantidad','detalle_entradas.precio_compra','productos.nombre as producto')
            ->where('detalle_entradas.identradas', '=',$id)
            ->orderBy('detalle_entradas.id', 'desc')->get();

        return ['detalles' => $detalles];
    }


    public function pdf(Request $request,$id){
        $entrada = Entrada::join('personas','entradas.idproveedores','=','personas.id')
        ->join('users','entradas.idusuarios','users.id')
        ->select('entradas.id','entradas.fecha_entrada','entradas.total_compra',
        'entradas.condicion',
        'personas.nombre','personas.tipo_documento',
        'personas.numero_documento','personas.direccion','personas.email',
        'personas.telefono','users.usuario')
        ->where('entradas.id', '=',$id)
        ->orderBy('entradas.id', 'desc')->take(1)->get();

        $detalles = DetalleEntrada::join('productos','detalle_entradas.idproductos','=','productos.id')
        ->select('detalle_entradas.cantidad','detalle_entradas.precio_compra',
        'productos.nombre as producto')
        ->where('detalle_entradas.identradas','=',$id)
        ->orderBy('detalle_entradas.id', 'desc')->get();

        $numentrada=Entrada::select('id')->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.entrada',['entrada'=>$entrada,'detalles'=>$detalles]);
        return $pdf->download('entrada-'.$numentrada[0]->id.'.pdf');
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        try{
            DB::beginTransaction();

            $fecha = Carbon::now();

            $entrada = new Entrada();
            $entrada->idproveedores = $request->idproveedores;
            $entrada->idusuarios = \Auth::user()->id;
            $entrada->fecha_entrada = $fecha;
            $entrada->total_compra = $request->total_compra;
            $entrada->condicion = '1';//activo
            $entrada->save();

            $detalles = $request->data;

            foreach ($detalles as $ep=>$det)
            {
                $detalle = new DetalleEntrada();
                $detalle->identradas = $entrada->id;
                $detalle->idproductos= $det['idproductos'];
                $detalle->cantidad= $det['cantidad'];
                $detalle->precio_compra= $det['precio_compra'];
                $detalle->save();
            }

           


            
            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

   
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $entrada = Entrada::findOrFail($request->id);
        $entrada->condicion = '0';
        $entrada->save();
    }

}
