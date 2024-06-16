<?php

namespace Mds\Moncash;

use Mds\Moncash\Core\Core;
use Mds\Moncash\Core\Constants;

use Mds\Moncash\Exception\MoncashException;

/**
 * Moncash
 * 
 * @package Mds\Moncash
 * @version 1.0.0
 * @license MIT
 * @author Mds <dev@louismidson.me>
 * 
 * 
 */
class Moncash extends Core
{
    /**
     * __construct - Create a new Moncash instance
     * 
     * 
     * ### Example Usage
     * 
     * ```php
     * 
     * $moncash = new Moncash('clientId', 'clientSecret', true);
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
        $this->_validateCredentials(
            $clientId,
            $clientSecret,
            $debug
        );

        parent::__construct(
            $clientId,
            $clientSecret,
            $debug
        );
    }

    /**
     * makePayment - Process Payment
     *
     * @param  string $orderId Order Id
     * @param  float|int $amount Amount to Paid
     * 
     * @return Payment Payment Object with Redirect Url
     * 
     * @throws MoncashException
     */
    public function makePayment(string $orderId, float|int $amount) : Payment
    {
        $this->_validatePaymentPayload($orderId, $amount);
        try {
            $res = $this->_client->post($this->_endpoint . Constants::PAYMENT_URI, [
                'headers' => $this->_getHeaders(),
                'json' => [
                    'orderId' => $orderId,
                    'amount' => $amount
                ]
            ]);

            return $this->_createPayment(
                $orderId,
                $amount,
                $res
            );
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
     * 
     * @return PaymentDetails Payment Details Object
     * 
     * @throws MoncashException
     */
    public function getPaymentDetailsByOrderId(string $orderId) : PaymentDetails
    {
        return $this->_getPaymentDetails($orderId, By::ORDER);
    }

    /**
     * getPaymentDetailsByTransactionId - Get Payment Details by Transaction Id
     *
     * @param  string $transactionId Transaction Id
     * 
     * @return PaymentDetails PaymentDetails Object
     * 
     * @throws MoncashException
     */
    public function getPaymentDetailsByTransactionId(string $transactionId) : PaymentDetails
    {
        return $this->_getPaymentDetails($transactionId, By::TRANSACTION);
    }

    /**
     * _createPayment - Create Payment Object
     *
     * @param  string $orderId 
     * @param  float|int $amount
     * @param  \Psr\Http\Message\ResponseInterface $res
     * 
     * @return Payment Payment Object
     * 
     * @throws MoncashException
     */
    private function _createPayment(string $orderId, float|int $amount, \Psr\Http\Message\ResponseInterface $res) : Payment
    {
        $data = json_decode($res->getBody());

        $expired = new \DateTime(
            strtotime($data->payment_token->expired)
        );

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
     * 
     * @return PaymentDetails PaymentDetails object
     * 
     * @throws MoncashException
     */
    private function _getPaymentDetails(string $identifier, By $by = By::TRANSACTION) : PaymentDetails
    {
        try {
            $url = $this->_endpoint;
            $url .= $by == By::TRANSACTION ?  Constants::DETAILS_TRANSACTION_URI : Constants::DETAILS_ORDER_URI;

            $res = $this->_client->post($url, [
                'headers' => $this->_getHeaders(),
                'json' => [
                    "{$by->value}Id" => $identifier,
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
