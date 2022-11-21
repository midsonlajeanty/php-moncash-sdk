<?php

namespace Mds\Moncashify\Core;

use GuzzleHttp\Exception\ClientException;

use Mds\Moncashify\Payment;

use Mds\Moncashify\Exception\CredentialsException;

class Core
{
    use Validation;

    private $id;
    private $secret;
    private $authorization;

    protected $_endpoint;
    protected $_baseGateway;
    protected $_client;


    public function __construct($id, $secret, $debug)
    {
        $this->id = $id;
        $this->secret = $secret;

        $this->setConfig($debug);
        $this->_client = new \GuzzleHttp\Client();

        $this->authorization = $this->__getAuthorization();
    }

    private function setConfig($debug)
    {
        $config = Config::set($debug);

        $this->_endpoint = $config->endpoint;
        $this->_baseGateway = $config->baseGateway;
    }

    protected function _createPayment($orderId, $amount, $data)
    {
        $handle = new \stdClass();
        $handle->token = $data->payment_token->token;
        $handle->base = $this->_baseGateway;

        $payment = new Payment($orderId, $amount, $handle);
        return $payment;
    }

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
            $data = json_decode($res->getBody());
            $auth = new Authorization($data);
            return $auth;
        } catch (ClientException $e) {
            throw new CredentialsException("Invalid credentials");
        }
    }

    protected function _getHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->authorization->getAuthorizationHeader()
        ];
    }

}
