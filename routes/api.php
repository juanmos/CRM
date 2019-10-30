<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login',['as'=>'login','uses'=>'APIAuthController@login']);
Route::post('usuario','APIAuthController@nuevoUsuario')->name('usuario.nuevo');


Route::middleware('jwt.auth')->post('geoposicion', 'APIAuthController@geoposicion');//Establecer la ubicacion del usuario actual


Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/usuario', 'APIAuthController@me');//Obtener los datos del usuario en sesion
    Route::delete('usuario/{plataforma}', 'APIAuthController@logout');//Cerrar sesion del usuario actual
    Route::post('usuario/registroPush', 'APIAuthController@registroPush');//Cerrar sesion del usuario actual

    Route::get('clientes/{usuario_id?}','ClienteController@index');
    Route::post('clientes/buscar/{usuario_id?}','ClienteController@buscar');
    Route::post('cliente','ClienteController@store');
    Route::get('cliente/visitas/{id}','ClienteController@visitas');
    Route::get('cliente/notas/{cliente_id}','NotaController@index');
    Route::post('cliente/nota','NotaController@store');
    Route::delete('cliente/nota/{id}','NotaController@destroy');

    Route::post('visitas/{id?}','Empresa\VisitaController@visitasByUsuario');
    Route::get('visita/{id}','Empresa\VisitaController@show');
    Route::post('visita','Empresa\VisitaController@store');
    Route::put('visita/{id}','Empresa\VisitaController@update');
    Route::post('visitas/visita/{id}/previsita','Empresa\VisitaController@savePrevisita');
    Route::post('visitas/visita/{id}/visita','Empresa\VisitaController@saveVisita');
    Route::get('visita/tareas/{id}','Empresa\VisitaController@tareasVisita');
    Route::get('visitas/historial/{id?}','Empresa\VisitaController@visitasByUsuarioHistorial');

    Route::get('clasificaciones','ClasificacionController@index');
    Route::get('vendedores','Empresa\UsuarioController@index');
    Route::get('oficinas/{cliente_id}','OficinaController@index');

    

    Route::get('tareas/{usuario_id?}/{tipo?}','Empresa\TareasController@index');
    Route::post('tareas','Empresa\TareasController@store');
    Route::put('tareas','Empresa\TareasController@update');
    Route::delete('tareas/{id}','Empresa\TareasController@destroy');
    Route::post('tarea/user/add','Empresa\TareasController@addUser');
    Route::get('tarea/user/delete/{user_id}/{tarea_id}','Empresa\TareasController@deleteUser');

    Route::put('cliente','ClienteController@actualizaCliente');
    Route::put('cliente/facturacion','ClienteController@actualizaFacturacion');

    Route::post('contacto/{cliente_id}/{json?}','ContactoController@store');
    Route::put('contacto/{id}','ContactoController@update');

    Route::post('oficina/{cliente_id}','OficinaController@store');
    Route::put('oficina/{id}','OficinaController@update');

    Route::get('tipoVisitas','TipoVisitaController@index');

    Route::put('direccion/{id}','OficinaController@update');

    Route::post('usuario','Empresa\UsuarioController@store');
    Route::get('usuario/roles','Empresa\UsuarioController@roles');
    Route::put('usuario/{id}','Empresa\UsuarioController@update');
    Route::delete('usuario/borrar/{id}','Empresa\UsuarioController@destroy');

    Route::get('metas/{fecha}','ObjetivoController@index');
    Route::get('meta/list/','ObjetivoController@lista');
    Route::post('meta','ObjetivoController@store');
    Route::put('meta/{id}','ObjetivoController@update');
});