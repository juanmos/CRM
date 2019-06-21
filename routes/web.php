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

Route::get('/', 'HomeController@index');

Auth::routes();
Route::get('logout','Auth\LoginController@logout')->name('logout');
Route::get('/home', 'HomeController@index')->name('home');


Route::resource('empresa', 'EmpresaController');
Route::resource('cliente', 'ClienteController');
Route::resource('visita', 'VisitaController');
Route::resource('tipoVisita', 'TipoVisitaController');
Route::resource('clasificacion', 'ClasificacionController');
Route::resource('usuario', 'UsuarioController');

Route::get('contacto/create/{cliente_id}', 'ContactoController@create')->name('contacto.create');
Route::post('contacto/store/{cliente_id}','ContactoController@store')->name('contacto.store');
Route::get('contacto/edit/{id}','ContactoController@edit')->name('contacto.edit');
Route::put('contacto/update/{id}','ContactoController@update')->name('contacto.update');

Route::get('oficina/create/{cliente_id}', 'OficinaController@create')->name('oficina.create');
Route::post('oficina/store/{cliente_id}','OficinaController@store')->name('oficina.store');
Route::get('oficina/edit/{id}','OficinaController@edit')->name('oficina.edit');
Route::put('oficina/update/{id}','OficinaController@update')->name('oficina.update');

Route::group(['prefix' => 'e'], function () {
    Route::resource('usuario', 'Empresa\UsuarioController',['as' => 'empresa']);
    Route::get('e/usuario/eliminados','Empresa\UsuarioController@eliminados')->name('empresa.usuario.eliminados');
    Route::get('e/usuario/restaurar/{id}','Empresa\UsuarioController@restaurar')->name('empresa.usuario.restaurar');
});