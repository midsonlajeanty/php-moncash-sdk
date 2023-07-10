<?php

namespace Mds\Moncash\Core;

use Mds\Moncash\Exception\MoncashException;

trait Validation
{


    /**
     * _validateCredentials
     *
     * @param  string $clientId User Client Id provided by Moncash
     * @param  string $clientSecret User Client Secret provided by Moncash
     * @param  string $debug Mode of use, `true` for development and `false` for production
     * 
     * @throws MoncashException 
     */
    protected function _validateCredentials(string $clientId, string $clientSecret, bool $debug)
    {
        if (empty($clientId) || empty($clientSecret)) {
            throw new MoncashException("'clientId' and 'clientSecret' must be provided");
        }

        if (!is_string($clientId) || !is_string($clientSecret)) {
            throw new MoncashException("'clientId' and 'clientSecret' must be string");
        }

        if (!is_bool($debug)) {
            throw new MoncashException("'debug' must be boolean");
        }
    }


    /**
     * _validatePaymentPayload
     *
     * @param  string $orderId Order Id
     * @param  float $amount Amount to be paid
     * 
     * @throws MoncashException
     */
    protected function _validatePaymentPayload(string $orderId, float|int $amount)
    {
        if (empty($orderId) || empty($amount)) {
            throw new MoncashException("'orderId' and 'amount' must be provided");
        }

        if (!is_numeric($amount)) {
            throw new MoncashException("'amount' must be a number");
        }

        if ($amount < 0) {
            throw new MoncashException("'amount' must be greater than 0");
        }
    }
}
