<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;


class ProductoController extends Controller
{
   
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        if ($buscar == '') {
            $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
            ->select('productos.id','productos.codigo',
            'productos.nombre', 'categorias.nombre as nombre_categoria','productos.precio_actual',
            'productos.stock','productos.descripcion','productos.condicion','productos.idcategorias')
            ->orderBy('productos.id', 'desc')->paginate(6);
        }
        else {
            $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
            ->select('productos.id','productos.codigo',
            'productos.nombre', 'categorias.nombre as nombre_categoria','productos.precio_actual',
            'productos.stock','productos.descripcion','productos.condicion','productos.idcategorias')
            ->where('productos.'.$criterio, 'like', '%'. $buscar .'%')
            ->orderBy('productos.id', 'desc')->paginate(6);
        }
        return[
            'pagination' =>[
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
    }


    public function listarProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
            ->select('productos.id','productos.codigo',
            'productos.nombre', 'categorias.nombre as nombre_categoria','productos.precio_actual',
            'productos.stock','productos.descripcion','productos.condicion','productos.idcategorias')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else {
            $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
            ->select('productos.id','productos.codigo',
            'productos.nombre', 'categorias.nombre as nombre_categoria','productos.precio_actual',
            'productos.stock','productos.descripcion','productos.condicion','productos.idcategorias')
            ->where('productos.'.$criterio, 'like', '%'. $buscar .'%')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        return['productos' => $productos];
    }

    

    public function buscarProducto(Request $request){
        if (!$request->ajax()) return redirect('/');
        
        $filtro = $request->filtro;
        $productos = Producto::where('codigo','=', $filtro)
        ->select('id','nombre')->orderBy('nombre','asc')->take(1)->get();

        return ['productos' => $productos];
    }

    public function listarProductoSalida(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar == '') {
            $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
            ->select('productos.id','productos.codigo',
            'productos.nombre', 'categorias.nombre as nombre_categoria','productos.precio_actual',
            'productos.stock','productos.descripcion','productos.condicion','productos.idcategorias')
            ->where('productos.stock','>','0')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        else {
            $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
            ->select('productos.id','productos.codigo',
            'productos.nombre', 'categorias.nombre as nombre_categoria','productos.precio_actual',
            'productos.stock','productos.descripcion','productos.condicion','productos.idcategorias')
            ->where('productos.'.$criterio, 'like', '%'. $buscar .'%')
            ->where('productos.stock','>','0')
            ->orderBy('productos.id', 'desc')->paginate(10);
        }
        return['productos' => $productos];
    }

    public function buscarProductoSalida(Request $request){
        if (!$request->ajax()) return redirect('/');
        
        $filtro = $request->filtro;
        $productos = Producto::where('codigo','=', $filtro)
        ->select('id','nombre','stock','precio_actual')
        ->where('stock','>','0')
        ->orderBy('nombre','asc')
        ->take(1)->get();
        return ['productos' => $productos];
    }



    public function store(Request $request)
    {
        //
        if (!$request->ajax()) return redirect('/');
        //instanciar el modelo
        $producto = new Producto();

        //tomar los datos de request
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_actual = $request->precio_actual;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->condicion= '1';//activo
        $producto->idcategorias= $request->idcategorias;

      

        //guardar el objeto en la tabla
        $producto->save();
    }


    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->id);
        
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->nombre;
        $producto->precio_actual = $request->precio_actual;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        $producto->condicion= '1';//activo
        $producto->idcategorias = $request->idcategorias;      
      
        //guardar el objeto en la tabla
        $producto->save();
    }


    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $producto =  Producto::findOrfail($request->id);
        $producto->condicion = 0; //desactivo
        $producto->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
          $producto =  Producto::findOrfail($request->id);
          $producto->condicion = 1; //activo
          $producto->save();
    }


    public function listarPdf(){
        
        $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
            ->select('productos.id','productos.codigo',
            'productos.nombre', 'categorias.nombre as nombre_categoria','productos.precio_actual',
            'productos.stock','productos.descripcion','productos.condicion','productos.idcategorias')
            ->orderBy('productos.nombre', 'desc')->get();

        $cont = Producto::count();

        $pdf = \PDF::loadView('pdf.productospdf', ['productos' => $productos, 'cont'=> $cont]);
        return $pdf->download('productos.pdf');

    }

    public function listarStockPdf(){
        
        $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
            ->select('productos.id','productos.codigo',
            'productos.nombre', 'categorias.nombre as nombre_categoria','productos.precio_actual',
            'productos.stock','productos.descripcion','productos.condicion','productos.idcategorias')
            ->where('stock','<=','5')
            ->orderBy('productos.nombre', 'desc')
            ->get();

        $cont = Producto::count();
        $pdf = \PDF::loadView('pdf.productos_stockpdf', ['productos' => $productos, 'cont'=> $cont]);
        return $pdf->download('Productos_Stock.pdf');
    }

    public function listarMesPdf(){
    
        $productos = Producto::join('categorias', 'productos.idcategorias', '=','categorias.id')
        ->select('productos.id','productos.codigo',
        'productos.nombre', 'categorias.nombre as nombre_categoria',
        'productos.precio_actual','productos.stock','productos.descripcion',
        'productos.condicion','productos.idcategorias','productos.created_at')
        ->whereMonth('productos.created_at', now()->month)
        ->get();

        $pdf = \PDF::loadView('pdf.productos_mespdf', ['productos' => $productos]);
        return $pdf->download('Productos_Mes.pdf');

    }
}
