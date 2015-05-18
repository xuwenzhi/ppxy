<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
$router->pattern('id', '[1-9][0-9]*');

Route::get('/home', 'Home\IndexController@index');

Route::get('/', 'Home\IndexController@index');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/error', function(){
	return '404';
});


Route::get('/admin', 'Admin\IndexController@index');

Route::get('/deny', 'Admin\AdminController@index');
