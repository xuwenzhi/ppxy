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

Route::group(['prefix' => '/user'], function()
{
	Route::any('checkemail', 'Home\UserController@checkEmailRepeat');
});

/**
 * 个人部分
 */
//Route::get('people/{username}', 'Home\IndividualController@page');
Route::get('setting', 'Home\IndividualController@setting');
Route::post('verifyphone', 'Home\IndividualController@verifyphone');
Route::post('doverifyphone', 'Home\IndividualController@doverifyphone');


/**
 * 商品部分
 */
Route::group(['prefix' => '/goods'], function()
{
	Route::get('new', ['middleware'           => 'auth', 'uses'=>'Home\GoodsController@tplNew']);
	Route::post('doNew', ['middleware'        => 'auth', 'uses'=>'Home\GoodsController@doNew']);
	Route::get('detail/{enId}', 'Home\GoodsController@detail');
	Route::get('find', 'Home\GoodsController@find');
	Route::get('mine', ['middleware'          => 'auth', 'uses'=>'Home\GoodsController@mine']);
	Route::get('modify/{enId}', ['middleware' => 'auth', 'uses'=>'Home\GoodsController@modify']);
	Route::post('subtype', ['middleware'      => 'auth', 'uses'=>'Home\GoodsController@getsubtype']);
	Route::post('upload', ['middleware'       => 'auth', 'uses' => 'Home\GoodsController@upload']);
	Route::post('doModify', ['middleware'     => 'auth', 'uses' => 'Home\GoodsController@doModify']);
	Route::post('deletephoto', ['middleware'  => 'auth', 'uses' => 'Home\GoodsController@doDeletePhoto']);
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
