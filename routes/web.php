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
Route::get('/informes/crearmeta/{id}', ['as' => 'informes.creategoal', 'uses' => 'BuildInformsController@createGoal']);
Route::post('/informes/guardarmeta/', ['as' => 'informes.storegoal', 'uses' => 'BuildInformsController@storeGoal']);
Route::get('/informes/crearvariable/{id}', ['as' => 'informes.createvariable', 'uses' => 'BuildInformsController@createVariable']);
Route::post('/informes/guardarvariable/', ['as' => 'informes.storevariable', 'uses' => 'BuildInformsController@storeVariable']);
Route::put('/informes/updateMeta', 'BuildInformsController@updateGoal');
Route::resource('informes', 'BuildInformsController');

//Resultados reportes - Administrador
Route::post('/resultados/generaravance','ResultController@buildProgress');
Route::resource('resultados', 'ResultController')->only(['index', 'show']);