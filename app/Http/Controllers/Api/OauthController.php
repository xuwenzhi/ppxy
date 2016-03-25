<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use Illuminate\Http\Request;

class OauthController extends Controller {

	public function __construct(){
		$this->middleware('oauth');
	}
	public function postToken(Request $request){
	     	$bridgedRequest  = OAuth2\HttpFoundationBridge\Request::createFromRequest($request->instance());
	        $bridgedResponse = new OAuth2\HttpFoundationBridge\Response();
	    
	        $bridgedResponse = App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);
	    
	         return $bridgedResponse;
	}
	
	public function getAllPosts(Request $request){
		$data = [1, 2, 3, 4];
		var_dump($request->all());
		return response($data, 201);
	}

}
