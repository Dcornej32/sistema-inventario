<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['guest']], function(){

    //++++ rutas para el login ++++//
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');

});

Route::group(['middleware' => ['auth']], function(){

        Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');


        Route::group(['middleware' => ['Administrador']], function(){
             
            //RUTAS DE LAS CATEGORIAS
            Route::get('/categoria', 'CategoriaController@index');
            Route::post('/categoria/registrar', 'CategoriaController@store');
            Route::put('/categoria/actualizar', 'CategoriaController@update');
            Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
            Route::put('/categoria/activar', 'CategoriaController@activar');
            Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
            
            
            ///   RUTAS DE PRODUCTO ////
            //listar todos los datos de la tabla
            Route::get('/producto', 'ProductoController@index');
            Route::post('/producto/registrar', 'ProductoController@store');
            Route::put('/producto/actualizar', 'ProductoController@update');
            Route::put('/producto/desactivar', 'ProductoController@desactivar');
            Route::put('/producto/activar', 'ProductoController@activar');
            
            //RUTAS DE LOS CLIENTES
            //tabla clientes listar,registrar y actualizar
            Route::get('/cliente', 'ClienteController@index');
            Route::post('/cliente/registrar', 'ClienteController@store');
            Route::put('/cliente/actualizar', 'ClienteController@update');
            Route::put('/cliente/desactivar', 'ClienteController@desactivar');
            Route::put('/cliente/activar', 'ClienteController@activar');
            
            //RUTAS DE LOS PROVEEDORES
            //tabla proveedores listar, registrar y actualizar
            Route::get('/proveedor', 'ProveedorController@index');
            Route::post('/proveedor/registrar', 'ProveedorController@store');
            Route::put('/proveedor/actualizar', 'ProveedorController@update');
            Route::put('/proveedor/desactivar', 'ProveedorController@desactivar');
            Route::put('/proveedor/activar', 'ProveedorController@activar');
            
            //RUTAS DE LOS ROLES
            //roles
            Route::get('/rol', 'RolController@index');
            Route::get('/rol/selectRol', 'RolController@selectRol');
            Route::post('/rol/registrar', 'RolController@store');
            Route::put('/rol/actualizar', 'RolController@update');
            Route::put('/rol/desactivar', 'RolController@desactivar');
            Route::put('/rol/activar', 'RolController@activar');
            
            //RUTAS DE LOS USUARIOS
            Route::get('/user', 'UserController@index');
            Route::post('/user/registrar', 'UserController@store');
            Route::put('/user/actualizar', 'UserController@update');
            Route::put('/user/desactivar', 'UserController@desactivar');
            Route::put('/user/activar', 'UserController@activar');
            
            
            //////******* Rutas para la tabla de informaciones  *******/////
            Route::get('/informacion', 'InformacionController@index');
            Route::post('/informacion/registrar', 'InformacionController@store');
            Route::put('/informacion/actualizar', 'InformacionController@update');
        });

        Route::group(['middleware' => ['Almacenero']], function(){

            //RUTAS DE LAS CATEGORIAS
            Route::get('/categoria', 'CategoriaController@index');
            Route::post('/categoria/registrar', 'CategoriaController@store');
            Route::put('/categoria/actualizar', 'CategoriaController@update');
            Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
            Route::put('/categoria/activar', 'CategoriaController@activar');
            Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
            
            
            ///   RUTAS DE PRODUCTO ////
            //listar todos los datos de la tabla
            Route::get('/producto', 'ProductoController@index');
            Route::post('/producto/registrar', 'ProductoController@store');
            Route::put('/producto/actualizar', 'ProductoController@update');
            Route::put('/producto/desactivar', 'ProductoController@desactivar');
            Route::put('/producto/activar', 'ProductoController@activar');
            
            //RUTAS DE LOS CLIENTES
            //tabla clientes listar,registrar y actualizar
            Route::get('/cliente', 'ClienteController@index');
            Route::post('/cliente/registrar', 'ClienteController@store');
            Route::put('/cliente/actualizar', 'ClienteController@update');
            Route::put('/cliente/desactivar', 'ClienteController@desactivar');
            Route::put('/cliente/activar', 'ClienteController@activar');
            
            //RUTAS DE LOS PROVEEDORES
            //tabla proveedores listar, registrar y actualizar
            Route::get('/proveedor', 'ProveedorController@index');
            Route::post('/proveedor/registrar', 'ProveedorController@store');
            Route::put('/proveedor/actualizar', 'ProveedorController@update');
            Route::put('/proveedor/desactivar', 'ProveedorController@desactivar');
            Route::put('/proveedor/activar', 'ProveedorController@activar');
            
            //////******* Rutas para la tabla de informaciones  *******/////
            Route::get('/informacion', 'InformacionController@index');
            Route::post('/informacion/registrar', 'InformacionController@store');
            Route::put('/informacion/actualizar', 'InformacionController@update');


        });
});

//Route::get('/home', 'HomeController@index')->name('home');
