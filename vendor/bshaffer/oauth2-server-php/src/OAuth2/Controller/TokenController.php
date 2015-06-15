<?php

namespace OAuth2\Controller;

use OAuth2\ResponseType\AccessTokenInterface;
use OAuth2\ClientAssertionType\ClientAssertionTypeInterface;
use OAuth2\GrantType\GrantTypeInterface;
use OAuth2\ScopeInterface;
use OAuth2\Scope;
use OAuth2\Storage\ClientInterface;
use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;
use OAuth2\Storage\AccessTokenInterface as AccessTokenStorageInterface;

/**
 * @see OAuth2\Controller\TokenControllerInterface
 */
class TokenController implements TokenControllerInterface
{
    protected $accessToken;
    protected $grantTypes;
    protected $clientAssertionType;
    protected $scopeUtil;
    protected $clientStorage;

    public function __construct(AccessTokenInterface $accessToken, ClientInterface $clientStorage, array $grantTypes = array(), ClientAssertionTypeInterface $clientAssertionType = null, ScopeInterface $scopeUtil = null)
    {
        if (is_null($clientAssertionType)) {
            foreach ($grantTypes as $grantType) {
                if (!$grantType instanceof ClientAssertionTypeInterface) {
                    throw new \InvalidArgumentException('You must supply an instance of OAuth2\ClientAssertionType\ClientAssertionTypeInterface or only use grant types which implement OAuth2\ClientAssertionType\ClientAssertionTypeInterface');
                }
            }
        }
        //数据表信息
        $this->clientAssertionType = $clientAssertionType;
        //更详细的数据表信息
        $this->accessToken = $accessToken;
        //数据表信息
        $this->clientStorage = $clientStorage;        
        foreach ($grantTypes as $grantType) {
            $this->addGrantType($grantType);
        }

        if (is_null($scopeUtil)) {
            $scopeUtil = new Scope();
        }
        $this->scopeUtil = $scopeUtil;
    }

    public function handleTokenRequest(RequestInterface $request, ResponseInterface $response)
    {
        if ($token = $this->grantAccessToken($request, $response)) {
            // @see http://tools.ietf.org/html/rfc6749#section-5.1
            // server MUST disable caching in headers when tokens are involved
            $response->setStatusCode(200);
            //$response->addParameters($token);
            //$token['user']['head'] = env('DOMAIN_IMG_ADDR').$token['user']['head'];
            $token['user']['head'] = $token['user']['head'] != '' ? env('DOMAIN_IMG_ADDR').$token['user']['head'] : '';
            /**
             * 返回创建的token
             */
            $response->addParameters(array(
                            'code' => 0,
                            'message'=>'',
                            'data'=>$token,
                        ));
            $response->addHttpHeaders(array('Cache-Control' => 'no-store', 'Pragma' => 'no-cache'));
        }
    }

    /**
     * Grant or deny a requested access token.
     * This would be called from the "/token" endpoint as defined in the spec.
     * You can call your endpoint whatever you want.
     *
     * @param $request - RequestInterface
     * Request object to grant access token
     *
     * @throws InvalidArgumentException
     * @throws LogicException
     *
     * @see http://tools.ietf.org/html/rfc6749#section-4
     * @see http://tools.ietf.org/html/rfc6749#section-10.6
     * @see http://tools.ietf.org/html/rfc6749#section-4.1.3
     *
     * @ingroup oauth2_section_4
     */
    public function grantAccessToken(RequestInterface $request, ResponseInterface $response)
    {
        if (strtolower($request->server('REQUEST_METHOD')) != 'post') {
            //$response->setError(405, '无效的请求', 'Token请以POST方式请求', '#section-3.2');
            $response->addParameters(array(
                        'code' => env('CODE_TOKEN_ERROR'),
                        'message'=>'无效的请求',
                        'data'=>array(),
                    ));
            $response->addHttpHeaders(array('Allow' => 'POST'));

            return null;
        }
        /**
         * Determine grant type from request
         * and validate the request for that grant type
         */
        if (!$grantTypeIdentifier = $request->request('grant_type')) {
            //$response->setError(400, '无效的请求', '请设置正确的GrantType');
            $response->addParameters(array(
                        'code' => env('CODE_TOKEN_ERROR'),
                        'message'=>'请设置正确的GrantType',
                        'data'=>array(),
                    ));
            return null;
        }

        if (!isset($this->grantTypes[$grantTypeIdentifier])) {
            /* TODO: If this is an OAuth2 supported grant type that we have chosen not to implement, throw a 501 Not Implemented instead */
            //$response->setError(200, '不支持此GrantType', sprintf('Grant type "%s" 不支持', $grantTypeIdentifier));
            $response->addParameters(array(
                        'code' => env('CODE_TOKEN_ERROR'),
                        'message'=>'不支持此GrantType',
                        'data'=>array(),
                    ));
            return null;
        }

        $grantType = $this->grantTypes[$grantTypeIdentifier];

        /**
         * Retrieve the client information from the request
         * ClientAssertionTypes allow for grant types which also assert the client data
         * in which case ClientAssertion is handled in the validateRequest method
         *
         * @see OAuth2\GrantType\JWTBearer
         * @see OAuth2\GrantType\ClientCredentials
         */
        if (!$grantType instanceof ClientAssertionTypeInterface) {
            if (!$this->clientAssertionType->validateRequest($request, $response)) {
                return null;
            }
            //clientID
            $clientId = $this->clientAssertionType->getClientId();
        }

        /**
         * Retrieve the grant type information from the request
         * The GrantTypeInterface object handles all validation
         * If the object is an instance of ClientAssertionTypeInterface,
         * That logic is handled here as well
         */
        if (!$grantType->validateRequest($request, $response)) {
            return null;
        }

        if ($grantType instanceof ClientAssertionTypeInterface) {
            $clientId = $grantType->getClientId();
        } else {
            // validate the Client ID (if applicable)
            if (!is_null($storedClientId = $grantType->getClientId()) && $storedClientId != $clientId) {
                //$response->setError(400, 'invalid_grant', sprintf('%s doesn\'t exist or is invalid for the client', $grantTypeIdentifier));
                $response->addParameters(array(
                        'code' => env('CODE_TOKEN_ERROR'),
                        'message'=>'不存在该Grant或无效的Client',
                        'data'=>array(),
                    ));
                return null;
            }
        }

        /**
         * Validate the client can use the requested grant type
         */
        // $grantTypeIdentifier = password;
        if (!$this->clientStorage->checkRestrictedGrantType($clientId, $grantTypeIdentifier)) {
            //$response->setError(400, '未认证的clientId', '此GrantType没有对该ClientID授权');
            $response->addParameters(array(
                        'code' => env('CODE_TOKEN_ERROR'),
                        'message'=>'此GrantType没有对该ClientID授权',
                        'data'=>array(),
                    ));
            return false;
        }
        /**
         * Validate the scope of the token
         *
         * requestedScope - the scope specified in the token request
         * availableScope - the scope associated with the grant type
         *  ex: in the case of the "Authorization Code" grant type,
         *  the scope is specified in the authorize request
         *
         * @see http://tools.ietf.org/html/rfc6749#section-3.3
         */

        $requestedScope = $this->scopeUtil->getScopeFromRequest($request);
        $availableScope = $grantType->getScope();

        if ($requestedScope) {
            // validate the requested scope
            if ($availableScope) {
                if (!$this->scopeUtil->checkScope($requestedScope, $availableScope)) {
                    //$response->setError(400, 'invalid_scope', 'The scope requested is invalid for this request');
                    $response->addParameters(array(
                        'code' => env('CODE_TOKEN_ERROR'),
                        'message'=>'无效的Scope',
                        'data'=>array(),
                    ));
                    return null;
                }
            } else {
                // validate the client has access to this scope
                if ($clientScope = $this->clientStorage->getClientScope($clientId)) {
                    if (!$this->scopeUtil->checkScope($requestedScope, $clientScope)) {
                        //$response->setError(400, 'invalid_scope', 'The scope requested is invalid for this client');
                        $response->addParameters(array(
                            'code' => env('CODE_TOKEN_ERROR'),
                            'message'=>'该Scope未对Client授权',
                            'data'=>array(),
                        ));
                        return false;
                    }
                } elseif (!$this->scopeUtil->scopeExists($requestedScope)) {
                    //$response->setError(400, 'invalid_scope', 'An unsupported scope was requested');
                    $response->addParameters(array(
                            'code' => env('CODE_TOKEN_ERROR'),
                            'message'=>'服务器不存在该Scope',
                            'data'=>array(),
                        ));
                    return null;
                }
            }
        } elseif ($availableScope) {
            // use the scope associated with this grant type
            $requestedScope = $availableScope;
        } else {
            // use a globally-defined default scope
            $defaultScope = $this->scopeUtil->getDefaultScope($clientId);

            // "false" means default scopes are not allowed
            if (false === $defaultScope) {
                //$response->setError(400, 'invalid_scope', 'This application requires you specify a scope parameter');
                $response->addParameters(array(
                            'code' => env('CODE_TOKEN_ERROR'),
                            'message'=>'您没有可授权的Scope',
                            'data'=>array(),
                        ));
                return null;
            }

            $requestedScope = $defaultScope;
        }
        return $grantType->createAccessToken($this->accessToken, $clientId, $grantType->getUserId(), $requestedScope);
    }

    /**
     * addGrantType
     *
     * @param grantType - OAuth2\GrantTypeInterface
     * the grant type to add for the specified identifier
     * @param identifier - string
     * a string passed in as "grant_type" in the response that will call this grantType
     */
    public function addGrantType(GrantTypeInterface $grantType, $identifier = null)
    {
        if (is_null($identifier) || is_numeric($identifier)) {
            $identifier = $grantType->getQuerystringIdentifier();
        }

        $this->grantTypes[$identifier] = $grantType;
    }
}
