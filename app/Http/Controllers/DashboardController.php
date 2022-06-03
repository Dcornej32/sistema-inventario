<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        
        $anio=date('Y');
        $entradas = DB::table('entradas as i')
        ->select(DB::raw('MONTHNAME(i.fecha_entrada) as mes'),
        DB::raw('YEAR(i.fecha_entrada) as anio'),
        DB::raw('SUM(i.total_compra) as total'))
        ->whereYear('i.fecha_entrada', $anio)
        ->groupBy(DB::raw('MONTHNAME(i.fecha_entrada) desc' ),DB::raw('YEAR(i.fecha_entrada)'))
        ->get();

        $salidas = DB::table('salidas as s')
        ->select(DB::raw('MONTHNAME(s.fecha_salida) as mes'),
        DB::raw('YEAR(s.fecha_salida) as anio'),
        DB::raw('SUM(s.total) as total'))
        ->whereYear('s.fecha_salida', $anio)
        ->groupBy(DB::raw('MONTHNAME(s.fecha_salida) desc' ),DB::raw('YEAR(s.fecha_salida)'))
        ->get();

        $stock = DB::table('productos')
        ->where('stock', '<=', 100)
        ->orderBy('stock', 'asc')
        ->limit(10)
        ->get(); 

        return ['entradas'=>$entradas, 'salidas'=>$salidas,'anio'=>$anio, 'stock' => $stock];
    }
}
