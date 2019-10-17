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

Route::group(['middleware' => ['auth']], function () {
Route::resource('empresa', 'EmpresaController');
    Route::resource('cliente', 'ClienteController');
    Route::resource('tipoVisita', 'TipoVisitaController');
    Route::resource('clasificacion', 'ClasificacionController');
    Route::resource('usuario', 'UsuarioController');
    Route::resource('configuracion', 'ConfiguracionController');
    Route::resource('plantilla','PlantillaController');

    Route::get('contacto/create/{cliente_id}', 'ContactoController@create')->name('contacto.create');
    Route::post('contacto/store/{cliente_id}/{json?}','ContactoController@store')->name('contacto.store');
    Route::get('contacto/edit/{id}','ContactoController@edit')->name('contacto.edit');
    Route::put('contacto/update/{id}','ContactoController@update')->name('contacto.update');
    Route::post('contacto/buscar/','ContactoController@buscar')->name('contacto.buscar');
    Route::delete('contacto/{id}','ContactoController@destroy')->name('contacto.destroy');

    Route::get('oficina/{cliente_id}','OficinaController@index')->name('oficina.index');
    Route::get('oficina/create/{cliente_id}', 'OficinaController@create')->name('oficina.create');
    Route::post('oficina/store/{cliente_id}','OficinaController@store')->name('oficina.store');
    Route::get('oficina/edit/{id}','OficinaController@edit')->name('oficina.edit');
    Route::put('oficina/update/{id}','OficinaController@update')->name('oficina.update');
    Route::delete('oficina/{id}','OficinaController@destroy')->name('oficina.destroy');

    Route::get('cliente/vendedor/{cliente_id}','ClienteController@vendedor')->name('cliente.vendedor');
    Route::get('cliente/listado/{user_id}','ClienteController@index')->name('cliente.listado');
    Route::get('cliente/asignar/{user_id}/{cliente_id}','ClienteController@asignar')->name('cliente.asignar');
    Route::post('cliente/asignarMultiple/{user_id}','ClienteController@asignarMultiple')->name('cliente.asignar.multiple');
    Route::get('cliente/desasignar/{user_id}/{cliente_id}','ClienteController@desasignar')->name('cliente.desasignar');
    Route::post('cliente/buscar','ClienteController@buscar')->name('cliente.buscar');
    Route::get('cliente/visitas/{id}','ClienteController@visitas')->name('cliente.visitas');
    Route::get('cliente/upload/csv','ClienteController@cargar')->name('cliente.upload');
    Route::post('cliente/import/csv','ClienteController@import')->name('cliente.import');

    Route::post('plantilla/campo/crear/{id}','PlantillaController@creaCampo')->name('plantilla.campo.create');
    Route::post('plantilla/campo/opciones/','PlantillaController@opcionesCampo')->name('plantilla.campo.opciones');
    Route::post('plantilla/campo/eliminar','PlantillaController@eliminarCampo')->name('plantilla.campo.eliminar');
    Route::post('plantilla/campo/orden/{id}','PlantillaController@ordenCampo')->name('plantilla.campo.orden');

    Route::post('cliente/nota','NotaController@store')->name('cliente.nota.store');
    Route::delete('cliente/nota/{id}','NotaController@destroy')->name('cliente.nota.destroy');

    Route::group(['prefix' => 'e'], function () {
        
        Route::get('visitas/vendedor/{id?}','Empresa\VisitaController@index')->name('visita.usuario');
        Route::get('visitas/by/vendedor/{id?}','Empresa\VisitaController@visitasByUsuario')->name('visita.vendedor');
        Route::get('visitas/visita/{id}/estado/{estado_id}','Empresa\VisitaController@cambiaEstado')->name('visita.estado');
        Route::post('visitas/visita/{id}/previsita','Empresa\VisitaController@savePrevisita')->name('visita.save.previsita');
        Route::post('visitas/visita/{id}/visita','Empresa\VisitaController@saveVisita')->name('visita.save.visita');
        Route::post('visitas/visita/{id}/user/add','Empresa\VisitaController@addUser')->name('visita.user.add');
        Route::get('visitas/visita/{id}/user/delete/{user_id}','Empresa\VisitaController@deleteUser')->name('visita.user.delete');
        Route::get('visitas/enviar/{id}','Empresa\VisitaController@enviar')->name('visita.enviar');

        Route::get('usuario/eliminados','Empresa\UsuarioController@eliminados')->name('empresa.usuario.eliminados');
        Route::get('usuario/restaurar/{id}','Empresa\UsuarioController@restaurar')->name('empresa.usuario.restaurar');
        Route::get('usuario/asignar','Empresa\UsuarioController@asignar')->name('empresa.usuario.asignar');
        Route::get('usuario/asignarme/{id}','Empresa\UsuarioController@asignarme')->name('empresa.usuario.asignarme');
        Route::get('usuario/desasignarme/{id}','Empresa\UsuarioController@desasignarme')->name('empresa.usuario.desasignarme');

        Route::get('tarea/mias/{usuario_id?}', 'Empresa\TareasController@index')->name('tarea.index');
        Route::post('tarea/crear', 'Empresa\TareasController@store')->name('tarea.store');
        Route::post('tarea/completada', 'Empresa\TareasController@update')->name('tarea.completada');
        Route::post('tarea/user/add','Empresa\TareasController@addUser')->name('tarea.user.add');
        Route::get('tarea/user/delete/{user_id}/{tarea_id}','Empresa\TareasController@deleteUser')->name('tarea.user.delete');

        Route::resource('usuario', 'Empresa\UsuarioController',['as' => 'empresa']);
        Route::resource('visita', 'Empresa\VisitaController');
        Route::get('e/usuario/create/{id?}','Empresa\UsuarioController@create')->name('empresa.usuario.create');
       // Route::get('visita/{id?}','Empresa\VisitaController@index')->name('visita.index');

        Route::get('ciudades','Empresa\VariosController@ciudades')->name('varios.ciudades');
    });
});