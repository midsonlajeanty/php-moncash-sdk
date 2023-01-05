<?php

namespace Mds\Moncashify\Core;

use Mds\Moncashify\Exception\AmountException;
use Mds\Moncashify\Exception\PaymentException;
use Mds\Moncashify\Exception\CredentialsException;


trait Validation {    
   
        
    /**
     * _validateCredentials
     *
     * @param  string $clientId User Client Id provided by Moncash
     * @param  string $clientSecret User Client Secret provided by Moncash
     * @param  string $debug Mode of use, `true` for development and `false` for production
     * 
     * @throws CredentialsException if clientId or clientSecret is empty
     * @throws CredentialsException if clientId or clientSecret is not a string
     * @throws CredentialsException if debug is not a boolean
     */
    protected function _validateCredentials(string $clientId, string $clientSecret, bool $debug)
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

    
    /**
     * _validatePaymentPayload
     *
     * @param  string $orderId Order Id
     * @param  float $amount Amount to be paid
     * 
     * @throws PaymentException if orderId or amount is empty
     * @throws AmountException if amount is not a number
     * @throws AmountException if amount is less than 0
     */
    protected function _validatePaymentPayload(string $orderId, float $amount)
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
}