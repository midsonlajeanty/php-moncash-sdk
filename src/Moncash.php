<?php

namespace Mds\Moncashify;

use Mds\Moncashify\Core\Core;
use Mds\Moncashify\Core\Constants;

use Mds\Moncashify\Exception\MoncashException;

/**
 * Moncashify
 * 
 * @package Mds\Moncashify
 * @version 1.0.0
 * @license MIT
 * @author Mds <mds@louismidson.me>
 * 
 * 
 */
class Moncash extends Core
{    
    /**
     * __construct - Create a new Moncashify instance
     * 
     * 
     * ### Example Usage
     * 
     * ```php
     * 
     * $moncash = new Moncashify('clientId', 'clientSecret', true);
     * 
     * $payment = $moncash->makePayment('orderId', 100); 
     * 
     * $payment->getRedirect(); // Redirect Url to Moncash Gateway
     * 
     * $details = $moncash->getPaymentDetailsByTransactionId('transactionId');
     * 
     * $details = $moncash->getPaymentDetailsByOrderId('orderId', 'order');
     * 
     * ```
     *
     * @param  string $clientId User Client Id provided by Moncash
     * @param  string $clientSecret User Client Secret provided by Moncash
     * @param  string $debug Mode of use, `true` for development and `false` for production. Default is `true`
     * 
     * @return void
     */
    public function __construct($clientId, $clientSecret, $debug = true)
    {
        $this->_validateCredentials($clientId, $clientSecret, $debug);
        parent::__construct($clientId, $clientSecret, $debug);
    }
    
    /**
     * makePayment - Process Payment
     *
     * @param  mixed $orderId Order Id
     * @param  mixed $amount Amount to Paid
     * 
     * @return Payment Payment Object with Redirect Url
     * 
     * @throws MoncashException
     */
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

            return $this->_createPayment($orderId, $amount, $res);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new MoncashException(
                $e->getResponse()->getBody()->getContents()
            );
        }
    }
    
    /**
     * getPaymentDetailsByOrderId - Get Payment Details by Order Id
     *
     * @param  string $orderId Order Id
     * @return PaymentDetails Payment Details Object
     */
    public function getPaymentDetailsByOrderId(string $orderId)
    {
        return $this->_getPaymentDetails($orderId, 'order');
    }
    
    /**
     * getPaymentDetailsByTransactionId - Get Payment Details by Transaction Id
     *
     * @param  string $transactionId Transaction Id
     * @return PaymentDetails PaymentDetails Object
     */
    public function getPaymentDetailsByTransactionId(string $transactionId)
    {
        return $this->_getPaymentDetails($transactionId, 'transaction');
    }

    /**
     * _createPayment - Create Payment Object
     *
     * @param  string $orderId 
     * @param  string $amount
     * @param  \Psr\Http\Message\ResponseInterface $res
     * @return PaymentDetails PaymentDetails Object
     */
    private function _createPayment($orderId, $amount, $res)
    {
        $data = json_decode($res->getBody());

        $expired = new \DateTime(strtotime($data->payment_token->expired));
        
        $payment = new Payment(
            $orderId, 
            $amount, 
            $data->payment_token->token, 
            $expired,
            $this->_baseGateway
        );

        return $payment;
    }
        
    /**
     * _getPaymentDetails - Get Payment Details from Moncash
     *
     * @param  string $identifier Transaction Id or Order Id
     * @param  string $scope Scope of the identifier, `transaction` or `order`. Default is `transaction`
     * @return void
     */
    private function _getPaymentDetails(string $identifier, string $scope = 'transaction')
    {
        try {
            $url = $this->_endpoint;
            $url .= $scope == 'transaction' ?  Constants::$DETAILS_TRANSACTION_URI : Constants::$DETAILS_ORDER_URI;
            
            $res = $this->_client->post($url, [
                'headers' => $this->_getHeaders(),
                'json' => [
                    "{$scope}Id" => $identifier, 
                ]
            ]);

            return  PaymentDetails::fromResponse($res);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new MoncashException(
                $e->getResponse()->getBody()->getContents()
            );
        }
    }
    
}
