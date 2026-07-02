<?php

declare(strict_types=1);

namespace Mds\Moncash;

use Mds\Moncash\Exception\ApiException;

/**
 * MoncashInterface - Public contract of the MonCash gateway.
 *
 * Type-hint against this interface in your application code so it can be
 * mocked in tests (the Moncash class is final by design). The Moncash class
 * is the production implementation.
 */
interface MoncashInterface
{
    /**
     * makePayment - Process a payment.
     *
     * @throws ApiException
     */
    public function makePayment(PaymentRequest $request): PaymentResponse;

    /**
     * getTransactionDetailsByOrderId - Retrieve transaction details by order id.
     *
     * @throws ApiException
     */
    public function getTransactionDetailsByOrderId(string $orderId): TransactionDetails;

    /**
     * getTransactionDetailsByTransactionId - Retrieve transaction details by transaction id.
     *
     * @throws ApiException
     */
    public function getTransactionDetailsByTransactionId(string $transactionId): TransactionDetails;
}
