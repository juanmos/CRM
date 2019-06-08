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


Route::get('contacto/create/{cliente_id}', 'ContactoController@create')->name('contacto.create');
Route::post('contacto/store/{cliente_id}','ContactoController@store')->name('contacto.store');
Route::get('contacto/edit/{id}','ContactoController@edit')->name('contacto.edit');
Route::put('contacto/update/{id}','ContactoController@update')->name('contacto.update');

Route::get('oficina/create/{cliente_id}', 'OficinaController@create')->name('oficina.create');
Route::post('oficina/store/{cliente_id}','OficinaController@store')->name('oficina.store');
Route::get('oficina/edit/{id}','OficinaController@edit')->name('oficina.edit');
Route::put('oficina/update/{id}','OficinaController@update')->name('oficina.update');

Route::resource('conductor', 'ConductorController');
Route::resource('hotel', 'HotelController');
Route::resource('aerolinea', 'AerolineaController')->middleware('auth');
Route::resource('usuario', 'UsuarioController');

Route::get('/empresa/usuario/create/{id}','EmpresaController@usuarioCreate')->name('empresa.usuario.create');
Route::post('/empresa/usuario/store/{id}','EmpresaController@usuarioStore')->name('empresa.usuario.store');
Route::get('/empresa/usuario/edit/{id}/{usuario_id}','EmpresaController@usuarioEdit')->name('empresa.usuario.edit');
Route::put('/empresa/usuario/update/{usuario_id}','EmpresaController@usuarioUpdate')->name('empresa.usuario.update');

Route::get('vuelo/{aerolinea_id}', 'VueloController@create')->name('vuelo.create');
Route::post('vuelo/{aerolinea_id}', 'VueloController@store')->name('vuelo.store');
Route::get('vuelo/{id}/edit', 'VueloController@edit')->name('vuelo.edit');
Route::put('vuelo/{id}', 'VueloController@update')->name('vuelo.update');