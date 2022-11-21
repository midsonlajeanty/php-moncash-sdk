<?php

namespace Mds\Moncashify;

use GuzzleHttp\Exception\ClientException;
use Mds\Moncashify\Exception\MoncashException;

use Mds\Moncashify\Core\Core;
use Mds\Moncashify\Core\Constants;


class Moncash extends Core
{
    public function __construct($clientId, $clientSecret, $debug = true)
    {
        $this->_validateCredentials($clientId, $clientSecret, $debug);
        parent::__construct($clientId, $clientSecret, $debug);
    }

    public function makePayment(string $orderId, float|int $amount)
    {
        $this->_validatePaymentPayload($orderId, $amount);
        try {
            $res = $this->_client->post($this->_endpoint . Constants::$PAYMENT_URI, [
                'headers' => $this->_getHeaders(),
                'json' => [
                    'orderId' => $orderId, 
                    'amount' => $amount
                ]
            ]);

            $data = json_decode($res->getBody());

            $payment = $this->_createPayment($orderId, $amount, $data);

            return $payment;
        } catch (ClientException $e) {
            throw new MoncashException($e->getMessage());
        }
    }

    public function getPaymentDetails(string $identifier, string $scope = 'transaction')
    {
        $this->_validatePaymentDetailsPayload($identifier, $scope);
        try {
            $url = $this->_endpoint;
            $url .= $scope == 'transaction' ?  Constants::$DETAILS_TRANSACTION_URI : Constants::$DETAILS_ORDER_URI;
            $res = $this->_client->post($url, [
                'headers' => $this->_getHeaders(),
                'json' => [
                    "{$scope}Id" => $identifier, 
                ]
            ]);

            $data = json_decode($res->getBody());

            $details = new PaymentDetails($data->payment);
            
            return $details;
        } catch (ClientException $e) {
            throw new MoncashException($e->getMessage());
        }
    }
    
}
