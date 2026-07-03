<?php

declare(strict_types=1);

namespace Mds\Moncash\Core;

use Mds\Moncash\Exception\InvalidPaymentRequestException;

trait Validation
{
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
