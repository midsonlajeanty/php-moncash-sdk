<?php

declare(strict_types=1);

namespace Mds\Moncash;

use GuzzleHttp\Exception\ClientException;
use Mds\Moncash\Core\Constants;
use Mds\Moncash\Core\Core;
use Mds\Moncash\Exception\ApiException;
use Psr\Http\Message\ResponseInterface;

/**
 * Moncash
 *
 * @version 2.0.0
 *
 * @license MIT
 * @author Mds <midsonlajeanty@proton.me>
 */
final class Moncash extends Core implements MoncashInterface
{
    /**
     * makePayment - Process Payment
     *
     * @param  PaymentRequest  $request  Payment request object
     * @return PaymentResponse Payment Response Object with redirect URL
     *
     * @throws ApiException
     */
    public function makePayment(PaymentRequest $request): PaymentResponse
    {
        $this->_validatePaymentPayload($request->getOrderId(), $request->getAmount());

        try {
            $res = $this->getClient()->request('POST', $this->_endpoint.Constants::PAYMENT_URI, [
                'headers' => $this->_getHeaders(),
                'json' => [
                    'orderId' => $request->getOrderId(),
                    'amount' => $request->getAmount(),
                ],
            ]);

            return $this->_createPayment($request, $res);
        } catch (ClientException $e) {
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
     * _createPayment - Build PaymentResponse from the API response
     *
     * @throws ApiException
     */
    private function _createPayment(PaymentRequest $request, ResponseInterface $res): PaymentResponse
    {
        $data = json_decode((string) $res->getBody());

        $expired = new \DateTime;
        $expired->setTimestamp((int) strtotime((string) $data->payment_token->expired));

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
        } catch (ClientException $e) {
            throw new ApiException($e->getResponse()->getBody()->getContents(), $e->getCode(), $e);
        }
    }
}
