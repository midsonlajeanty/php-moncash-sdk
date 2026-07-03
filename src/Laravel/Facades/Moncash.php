<?php

declare(strict_types=1);

namespace Mds\Moncash\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Mds\Moncash\MoncashInterface;
use Mds\Moncash\PaymentRequest;
use Mds\Moncash\PaymentResponse;
use Mds\Moncash\TransactionDetails;

/**
 * Laravel facade for the MonCash gateway.
 *
 * @method static PaymentResponse makePayment(PaymentRequest $request)
 * @method static TransactionDetails getTransactionDetailsByOrderId(string $orderId)
 * @method static TransactionDetails getTransactionDetailsByTransactionId(string $transactionId)
 *
 * @see \Mds\Moncash\Moncash
 */
final class Moncash extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MoncashInterface::class;
    }
}
