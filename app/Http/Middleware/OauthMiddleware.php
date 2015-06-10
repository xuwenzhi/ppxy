<?php namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use OAuth2\HttpFoundationBridge\Request as OAuthRequest;

class OauthMiddleware{
	public function handle($request, Closure $next){
		if(!$request->input('access_token')){
			return response( 'Token not found', 422);
		}
		$req = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
		$bridgeRequest = OAuthRequest::createFromRequest($req);
		$bridgeResponse = new \OAuth2\HttpFoundationBridge\Response();
		
		if(!$token = App::make('oauth2')->getAccessTokenData($bridgeRequest, $bridgeResponse)){
			$response = App::make('oauth2')->getResponse();
			if($response -> getParameter('error') == 'expired_token'){
				return response('The access token provided has expired', 401);
			}
			return response('Invalid Token.', 422);
		} else {
			$request['user_id'] = $token['user_id'];
		}
		return $next($request);
	}
}
