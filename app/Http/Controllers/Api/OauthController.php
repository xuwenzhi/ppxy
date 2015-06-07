<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use OAuth2\HttpFoundationBridge\Request as OAuth2Request;
use OAuth2\HttpFoundationBridge\Response as OAuth2Response;
class OauthController extends Controller {

	public function token(){
		$bridgedRequest  = \OAuth2\HttpFoundationBridge\Request::createFromRequest(Request::instance());
	    $bridgedResponse = new \OAuth2\HttpFoundationBridge\Response();
	    
	    $bridgedResponse = App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);
	    
	    return $bridgedResponse;
	}

}
