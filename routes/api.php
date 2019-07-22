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

Route::middleware('jwt.auth')->get('/usuario', 'APIAuthController@me');//Obtener los datos del usuario en sesion
Route::middleware('jwt.auth')->delete('usuario/{plataforma}', 'APIAuthController@logout');//Cerrar sesion del usuario actual
Route::middleware('jwt.auth')->post('usuario/registroPush', 'APIAuthController@registroPush');//Cerrar sesion del usuario actual
Route::middleware('jwt.auth')->post('geoposicion', 'APIAuthController@geoposicion');//Establecer la ubicacion del usuario actual
Route::middleware('jwt.auth')->get('saldo', 'APIAuthController@saldo');//Saldo del conductor

