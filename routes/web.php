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

Route::get('/', function () {
    return view('contenido/contenido');
});

//listar todos los datos de la tabla
Route::get('/categoria', 'CategoriaController@index');

//insertar registros en la tabla
Route::post('/categoria/registrar', 'CategoriaController@store');

//insertar registros en la tabla
Route::put('/categoria/actualizar', 'CategoriaController@update');

//desactivar registros en la tabla
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');

//activar registros en la tabla
Route::put('/categoria/activar', 'CategoriaController@activar');

//para seleccionar categoria
Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');


///   RUTAS DE PRODUCTO ////
//listar todos los datos de la tabla
Route::get('/producto', 'ProductoController@index');

//insertar registros en la tabla
Route::post('/producto/registrar', 'ProductoController@store');

//insertar registros en la tabla
Route::put('/producto/actualizar', 'ProductoController@update');

//desactivar registros en la tabla
Route::put('/producto/desactivar', 'ProductoController@desactivar');

//activar registros en la tabla
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
