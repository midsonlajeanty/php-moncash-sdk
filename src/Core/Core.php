<?php

namespace Mds\Moncashify\Core;

use Mds\Moncashify\Exception\MoncashException;

/**
 * Core
 * @final
 */
class Core
{
    use Validation;
    
    /**
     * id - Client Id
     *
     * @var string User Client Id provided by Moncash
     */
    private $id;
        
    /**
     * secret - Client Secret
     *
     * @var string User Client Secret provided by Moncash
     */
    private $secret;  

    /**
     * authorization - Authorization 
     *
     * @var Authorization Authorization Instance with Access Token
     */
    private $authorization;
    
    /**
     * _endpoint - Base URL
     *
     * @var string - Moncash Base URL
     */
    protected $_endpoint;
    
    /**
     * _baseGateway - Base Gateway
     *
     * @var string - Moncash Base Gateway
     */
    protected $_baseGateway;
    
    /**
     * _client - API Client
     *
     * @var \GuzzleHttp\Client - Guzzle Client
     */
    protected $_client;

    
    /**
     * __construct - Create Core Instance
     * 
     * - Set Config `development` or `production`
     * - Create API Client Instance
     * - Get Authorization Token
     *
     * @param  string $id User Client Id provided by Moncash
     * @param  string $secret User Client Secret provided by Moncash
     * @param  string $debug Mode of use, `true` for development and `false` for production
     * @return void
     */
    public function __construct($id, $secret, $debug)
    {
        $this->id = $id;
        $this->secret = $secret;

        $this->setConfig($debug);
        $this->_client = new \GuzzleHttp\Client();

        $this->authorization = $this->__getAuthorization();
    }

    
    /**
     * setConfig - Set Config for `development` or `production` 
     * 
     * - Set Base URL
     * - Set Base Gateway
     *
     * @param  bool $debug
     * @return void
     */
    private function setConfig($debug)
    {
        $config = new \stdClass();

        if($debug){
            $config->endpoint = Constants::$SANDBOX_URL;
            $config->baseGateway = Constants::$SANDBOX_BASE_GATEWAY;
        }else{
            $config->endpoint = Constants::$LIVE_URL;
            $config->baseGateway = Constants::$LIVE_BASE_GATEWAY;
        }

        $this->_endpoint = $config->endpoint;
        $this->_baseGateway = $config->baseGateway;
    }
    
    /**
     * __getAuthorization - Get Authorization Token
     *
     * @return Authorization Authorization Instance with Access Token
     * @throws MoncashException
     */
    private function __getAuthorization()
    {
        try {
            $res = $this->_client->post($this->_endpoint . Constants::$TOKEN_URI, [
                'auth' => [$this->id, $this->secret],
                'query' => [
                    'grant_type' => 'client_credentials',
                    'scope' => 'read,write'
                ],
            ]);
            
            return Authorization::fromResponse($res);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new MoncashException(
                $e->getResponse()->getBody()->getContents(),
            );
        }
    }
    
    /**
     * _getHeaders - Get Headers
     * 
     * - Accept
     * - Content-Type
     * - Authorization
     *
     * @return array Headers
     */
    protected function _getHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->authorization->getAuthorizationHeader()
        ];
    }

}
