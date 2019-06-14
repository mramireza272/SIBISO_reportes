<?php
/*DB::listen(function($query){
	echo "<pre>{$query->sql}</pre>";
});*/
//colocar de la siguiente manera System/recurso

Route::get('/', function () {
    return redirect('/login');
});

//Global
Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout', 'Auth\LoginController@logout');
Auth::routes();
Route::auth();
Route::resource('roles', 'RolesController');
Route::resource('permisos', 'PermissionsController');
Route::resource('bitacora', 'LogController');
Route::resource('usuarios', 'UserController')->except(['show']);
Route::match(['get', 'post'], '/usuarios/busqueda', ['as' => 'usuarios.search', 'uses' => 'UserController@search']);
Route::resource('reportes', 'BuildFormController');
Route::get('/formularios/nuevaColumna/{id}', 'CreateFormController@buildCol');
Route::get('/formularios/eliminarColumna/{item_id}/{structure_id}', 'CreateFormController@destroyCol');
Route::put('/formularios/actualizarNombre', 'CreateFormController@updateInputName');
Route::put('/formularios/actualizarEditable', 'CreateFormController@updateEditable');
Route::get('/formularios/nuevaFila/{rol_id}/{parent_id}', 'CreateFormController@buildRow');
Route::resource('formularios', 'CreateFormController');

Route::resource('form', 'saveForm');
Route::post('saveform', 'saveForm@store');
Route::get('edtform/{id?}','saveForm@edit');
Route::post('updateform/','saveForm@update');
//Route::resource('edtrol/{id?}/','CreateFormController');
Route::get('add/{dones?}/{id?}','CrudFormController@create');
Route::get('rm/{dones?}/{id?}','CrudFormController@destroy');
Route::get('update/{dones?}/{id?}','CrudFormController@update');

