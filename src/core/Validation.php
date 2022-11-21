<?php

namespace Mds\Moncashify\Core;

use Mds\Moncashify\Exception\AmountException;
use Mds\Moncashify\Exception\PaymentException;
use Mds\Moncashify\Exception\CredentialsException;
use Mds\Moncashify\Exception\PaymentDetailsException;

trait Validation {
    protected function _validateCredentials($clientId, $clientSecret, $debug)
    {
        if (empty($clientId) || empty($clientSecret)) {
            throw new CredentialsException("'clientId' and 'clientSecret' must be provided");
        }

        if (!is_string($clientId) || !is_string($clientSecret)) {
            throw new CredentialsException("'clientId' and 'clientSecret' must be string");
        }

        if (!is_bool($debug)) {
            throw new CredentialsException("'debug' must be boolean");
        }
    }

    protected function _validatePaymentPayload($orderId, $amount)
    {
        if (empty($orderId) || empty($amount)) {
            throw new PaymentException("'orderId' and 'amount' must be provided");
        }

        if (!is_numeric($amount)) {
            throw new AmountException("'amount' must be a number");
        }

        if ($amount < 0) {
            throw new AmountException("'amount' must be greater than 0");
        }
    }

    public function _validatePaymentDetailsPayload($identifier, $scope)
    {
        if(!in_array($scope, ['transaction', 'order'])){
            throw new PaymentDetailsException("'scope' must be 'transaction' or 'order'");
        }

        if (empty($identifier)) {
            throw new PaymentDetailsException("'transactionId' or 'orderId' must be provided");
        }
    }
}