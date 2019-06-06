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
Route::resource('forma', 'BuildForm');
Route::resource('form', 'saveForm');
Route::post('saveform', 'saveForm@store');
Route::get('edtform/{id?}','saveForm@edit');