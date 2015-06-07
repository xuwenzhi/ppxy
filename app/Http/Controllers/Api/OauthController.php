<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class OauthController extends Controller {

	public function postToken(Request $request){
       	$bridgedRequest  = \OAuth2\HttpFoundationBridge\Request::createFromRequest($request->instance());
	    $bridgedResponse = new \OAuth2\HttpFoundationBridge\Response();
	    
	    $bridgedResponse = App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);
	    
	    return $bridgedResponse;
	}

}
