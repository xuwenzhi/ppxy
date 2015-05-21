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

/**
 * 个人部分
 */
//Route::get('people/{username}', 'Home\IndividualController@page');
Route::get('setting', 'Home\IndividualController@setting');


/**
 * 商品部分
 */
Route::group(['prefix' => '/goods'], function()
{
	Route::get('new', ['middleware' => 'auth', 'uses'=>'Home\GoodsController@tplNew']);
	Route::post('doNew', ['middleware' => 'auth', 'uses'=>'Home\GoodsController@doNew']);
	Route::get('detail/{enId}', 'Home\GoodsController@detail');
	Route::get('find', 'Home\GoodsController@find');
	Route::get('mine', ['middleware' => 'auth', 'uses'=>'Home\GoodsController@mine']);
});




/**
 * 通用部分
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/error', function(){
	return '404';
});


/**
 * 后台
 */
Route::get('/admin', 'Admin\IndexController@index');
Route::get('/deny', 'Admin\AdminController@index');

Route::group(['prefix' => '/aduser'], function()
{
	Route::get('all', 'Admin\UserController@userall');
	Route::get('today', 'Admin\UserController@today');
	Route::get('member', 'Admin\UserController@member');
	Route::get('pending', 'Admin\UserController@pending');
	Route::get('detail/{enId}', 'Admin\UserController@detail');
});

Route::group(['prefix' => '/adgoods'], function()
{
	Route::get('all', 'Admin\GoodsController@all');
	Route::get('newbie', 'Admin\GoodsController@newbie');
	Route::get('hide', 'Admin\GoodsController@hide');
	Route::get('close', 'Admin\GoodsController@close');
	Route::get('detail/{enId}', 'Admin\GoodsController@detail');
});
