<?php

declare(strict_types=1);

namespace Mds\Moncash\Core;

use Mds\Moncash\Exception\InvalidConfigException;
use Mds\Moncash\Exception\InvalidPaymentRequestException;

trait Validation
{
    /**
     * _validateCredentials
     *
     * @param  string  $clientId  User Client Id provided by Moncash
     * @param  string  $clientSecret  User Client Secret provided by Moncash
     *
     * @throws InvalidConfigException
     */
    protected function _validateCredentials(string $clientId, string $clientSecret): void
    {
        if ($clientId === '' || $clientId === '0' || ($clientSecret === '' || $clientSecret === '0')) {
            throw new InvalidConfigException("'clientId' and 'clientSecret' must be provided");
        }
    }

    /**
     * _validatePaymentPayload
     *
     * @param  string  $orderId  Order Id
     * @param  float  $amount  Amount to be paid
     *
     * @throws InvalidPaymentRequestException
     */
    protected function _validatePaymentPayload(string $orderId, float $amount): void
    {
        if ($orderId === '' || $orderId === '0') {
            throw new InvalidPaymentRequestException("'orderId' must be provided");
        }

        if ($amount <= 0) {
            throw new InvalidPaymentRequestException("'amount' must be greater than 0");
        }
    }
}
