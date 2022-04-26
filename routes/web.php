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
