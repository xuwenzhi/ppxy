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
// API
App::singleton('oauth2', function() {
 
	 $storage = new OAuth2\Storage\Pdo(array(
		'dsn' => 'mysql:dbname=ishare_school;host=localhost', 'username' => 'root', 'password' => env('DB_PASSWORD', '')));
	 $server = new OAuth2\Server($storage);
	 $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));
	 $server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));
 
	 return $server;
});
Route::post('oauth/token', function()
{	
    $bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
    $bridgedResponse = new OAuth2\HttpFoundationBridge\Response();
    
    $bridgedResponse = App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);
    
    return $bridgedResponse;
});
Route::post('oauth/test', 'Api\OauthController@postToken');


Route::group(['prefix' => 'post'], function(){
	post('list', 'Api\OauthController@getAllPosts');	
});



//Tools
Route::get('/sysnoauth', 'Tools\sysnUsersToOauth@run');
Route::get('/task/run',array('uses'=>'TaskController@run'));






$router->pattern('id', '[1-9][0-9]*');

Route::get('/home', 'Home\IndexController@index');

Route::get('/', 'Home\IndexController@index');
Route::get('complex', 'Home\IndexController@complexList');
Route::get('big4', 'Home\IndexController@big4List');
Route::post('/loadmore', 'Home\IndexController@load_more');
Route::get('/about', function(){
	return View::make('app.other.about');
});

Route::get('/search/{keyword}','Home\GoodsController@lookFor');


Route::group(['prefix' => '/user'], function()
{
	Route::any('checkemail', 'Home\UserController@checkEmailRepeat');
});

/**
 * 个人部分
 */
//Route::get('people/{username}', 'Home\IndividualController@page');
Route::get('verify/{resource?}', 'Home\IndividualController@setting');
Route::post('verifyphone', 'Home\IndividualController@verifyphone');
Route::post('doverifyphone', 'Home\IndividualController@doverifyphone');


//todo 当在PC端修改密码时，同步到oauth_users表中，后期会干掉
Route::post('/user/updatepass','Home\UserController@updateUserPass');





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
	Route::get('surprise/{type}', 'Home\GoodsController@surprise');
	Route::post('ajaxmine', 'Home\GoodsController@ajax_mine');
	Route::post('ajaxstatus','Home\GoodsController@ajax_status');
	Route::post('/h5upload', 'Home\GoodsController@uploadImgReturnPath');
	Route::post('ajaxlookfor','Home\GoodsController@ajax_lookfor');
});


/**
 * 订单部分
 */
Route::group(['prefix' => '/order'], function()
{
	Route::get('{enId}/precheck', ['middleware' => 'auth', 'uses'=>'Home\OrderController@precheck']);
	Route::post('create', ['middleware' => 'auth', 'uses'=>'Home\OrderController@create']);
	Route::get('{enId}/detail', ['middleware' => 'auth', 'uses'=>'Home\OrderController@detail']);
	Route::get('mine', ['middleware' => 'auth', 'uses'=>'Home\OrderController@mine']);
	Route::get('surprise/{type}', 'Home\OrderController@surprise');
});


/**
 * 通用部分
 */
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/error', function(){
	return 'error';
});
Route::get('/404', function(){
	return View::make('errors.404');
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
