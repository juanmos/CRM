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
    Route::get('clientes','ClienteController@index');
    Route::get('tareas','Empresa\TareasController@index');
    Route::post('visitas/{id?}','Empresa\VisitaController@visitasByUsuario');
    Route::get('clasificaciones','ClasificacionController@index');
    Route::get('vendedores','Empresa\UsuarioController@index');

    Route::post('cliente','ClienteController@store');
    Route::post('tareas','Empresa\TareasController@store');
    Route::put('tareas','Empresa\TareasController@update');
});