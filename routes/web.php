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

//Roles y permisos
Route::resource('roles', 'RolesController');
Route::resource('permisos', 'PermissionsController');
Route::resource('usuarios', 'UserController')->except(['show']);
Route::match(['get', 'post'], '/usuarios/busqueda', ['as' => 'usuarios.search', 'uses' => 'UserController@search']);

//Bitácora
Route::resource('bitacora', 'LogController');

//Realizar reportes - Unidades Administrativas
Route::resource('reportes', 'BuildFormController');

//CRUD formularios
Route::get('/formularios/nuevaColumna/{id}', 'CreateFormController@buildCol');
Route::get('/formularios/eliminarColumna/{item_id}/{structure_id}', 'CreateFormController@destroyCol');
Route::put('/formularios/actualizarNombre', 'CreateFormController@updateInputName');
Route::put('/formularios/actualizarEditable', 'CreateFormController@updateEditable');
Route::get('/formularios/nuevaFila/{rol_id}/{parent_id}', 'CreateFormController@buildRow');
Route::get('/formularios/eliminarFila/{parent_id}/{item_id}', 'CreateFormController@destroyRow');
Route::resource('formularios', 'CreateFormController');

//CRUD reportes - Administrador
Route::resource('informes', 'BuildInformsController');

#DISPATCHERS FOR RESULTS
Route::resource('result/', 'ResultController');
Route::resource('makeresult/', 'buildResultController');

Route::get('addresult/', 'buildResultController@addresult');
Route::get('rmresult/', 'buildResultController@rmresult');
Route::get('addformula/', 'buildResultController@addformula');
Route::get('rmformula/', 'buildResultController@rmformula');

Route::resource('makeformula/', 'buildFormulaController');
Route::get('/savevariables/', 'buildFormulaController@create');
