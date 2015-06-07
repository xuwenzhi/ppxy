<?php namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use OAuth2\HttpFoundationBridge\Request as OAuth2Request;
use OAuth2\HttpFoundationBridge\Response as OAuth2Response;
class OauthController extends Controller {

	public function postToken(Request $request){
       	$bridgedRequest  = OAuth2Request::createFromRequest($request->instance());
	    $bridgedResponse = new OAuth2Response();
	    
	    $bridgedResponse = App::make('oauth2')->handleTokenRequest($bridgedRequest, $bridgedResponse);
	    
	    return $bridgedResponse;
	}

}
