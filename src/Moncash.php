<?php

declare(strict_types=1);

namespace Mds\Moncash;

use Mds\Moncash\Core\Core;
use Mds\Moncash\Core\Constants;
use Mds\Moncash\Exception\ApiException;

/**
 * Moncash
 *
 * @version 2.0.0
 *
 * @license MIT
 * @author Mds <midsonlajeanty@proton.me>
 */
class Moncash extends Core
{
    /**
     * __construct - Create a new Moncash instance
     *
     * Standard usage:
     *   $moncash = new Moncash(new Config('clientId', 'clientSecret'), true);
     *
     * Deprecated usage (still supported):
     *   $moncash = new Moncash('clientId', 'clientSecret', true);
     *
     * @param  Config|string  $config  Config object (standard) or clientId (deprecated)
     * @param  bool|string  $secretOrDebug  debug flag (standard) or clientSecret (deprecated)
     * @param  bool  $debug  Deprecated mode only
     */
    public function __construct($config, $secretOrDebug = true, bool $debug = true)
    {
        if ($config instanceof Config) {
            $resolvedConfig = $config;
            $resolvedDebug = is_bool($secretOrDebug) ? $secretOrDebug : true;
        } else {
            @trigger_error(
                'Passing clientId/clientSecret to Moncash::__construct() is deprecated, use Mds\Moncash\Config instead.',
                E_USER_DEPRECATED
            );
            $this->_validateCredentials((string) $config, (string) $secretOrDebug);
            $resolvedConfig = new Config((string) $config, (string) $secretOrDebug);
            $resolvedDebug = $debug;
        }

        parent::__construct($resolvedConfig, $resolvedDebug);
    }

    /**
     * makePayment - Process Payment
     *
     * @param  PaymentRequest|string  $request  PaymentRequest (standard) or orderId (deprecated)
     * @param  float|null  $amount  Amount (deprecated mode only)
     * @return PaymentResponse Payment Response Object with redirect URL
     *
     * @throws ApiException
     */
    public function makePayment($request, $amount = null): PaymentResponse
    {
        if ($request instanceof PaymentRequest) {
            $paymentRequest = $request;
        } else {
            @trigger_error(
                'Passing orderId/amount to makePayment() is deprecated, use Mds\Moncash\PaymentRequest instead.',
                E_USER_DEPRECATED
            );
            $paymentRequest = new PaymentRequest((string) $request, (float) $amount);
        }

        $this->_validatePaymentPayload($paymentRequest->getOrderId(), $paymentRequest->getAmount());

        try {
            $res = $this->getClient()->request('POST', $this->_endpoint . Constants::PAYMENT_URI, [
                'headers' => $this->_getHeaders(),
                'json' => [
                    'orderId' => $paymentRequest->getOrderId(),
                    'amount' => $paymentRequest->getAmount(),
                ],
            ]);

            return $this->_createPayment($paymentRequest, $res);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new ApiException($e->getResponse()->getBody()->getContents(), $e->getCode(), $e);
        }
    }

    /**
     * getTransactionDetailsByOrderId - Get Transaction Details by Order Id
     *
     * @param  string  $orderId  Order Id
     *
     * @throws ApiException
     */
    public function getTransactionDetailsByOrderId(string $orderId): TransactionDetails
    {
        return $this->_getTransactionDetails($orderId, By::ORDER);
    }

    /**
     * getTransactionDetailsByTransactionId - Get Transaction Details by Transaction Id
     *
     * @param  string  $transactionId  Transaction Id
     *
     * @throws ApiException
     */
    public function getTransactionDetailsByTransactionId(string $transactionId): TransactionDetails
    {
        return $this->_getTransactionDetails($transactionId, By::TRANSACTION);
    }

    /**
     * getPaymentDetailsByOrderId - Deprecated, use getTransactionDetailsByOrderId() instead
     *
     * @deprecated Use getTransactionDetailsByOrderId() instead.
     */
    public function getPaymentDetailsByOrderId(string $orderId): TransactionDetails
    {
        @trigger_error('getPaymentDetailsByOrderId() is deprecated, use getTransactionDetailsByOrderId() instead.', E_USER_DEPRECATED);

        return $this->getTransactionDetailsByOrderId($orderId);
    }

    /**
     * getPaymentDetailsByTransactionId - Deprecated, use getTransactionDetailsByTransactionId() instead
     *
     * @deprecated Use getTransactionDetailsByTransactionId() instead.
     */
    public function getPaymentDetailsByTransactionId(string $transactionId): TransactionDetails
    {
        @trigger_error('getPaymentDetailsByTransactionId() is deprecated, use getTransactionDetailsByTransactionId() instead.', E_USER_DEPRECATED);

        return $this->getTransactionDetailsByTransactionId($transactionId);
    }

    /**
     * _createPayment - Build PaymentResponse from the API response
     *
     * @throws ApiException
     */
    private function _createPayment(PaymentRequest $request, \Psr\Http\Message\ResponseInterface $res): PaymentResponse
    {
        $data = json_decode((string) $res->getBody());

        $expired = new \DateTime();
        $expired->setTimestamp((int) strtotime($data->payment_token->expired));

        return new PaymentResponse(
            $request->getOrderId(),
            $request->getAmount(),
            (string) $data->payment_token->token,
            $expired,
            $this->_baseGateway
        );
    }

    /**
     * _getTransactionDetails - Retrieve transaction details from Moncash
     *
     * @throws ApiException
     */
    private function _getTransactionDetails(string $identifier, string $by = By::TRANSACTION): TransactionDetails
    {
        try {
            $url = $this->_endpoint;
            $url .= $by === By::TRANSACTION ? Constants::DETAILS_TRANSACTION_URI : Constants::DETAILS_ORDER_URI;

            $res = $this->getClient()->request('POST', $url, [
                'headers' => $this->_getHeaders(),
                'json' => [
                    "{$by}Id" => $identifier,
                ],
            ]);

            return TransactionDetails::fromResponse($res);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new ApiException($e->getResponse()->getBody()->getContents(), $e->getCode(), $e);
        }
    }
}
