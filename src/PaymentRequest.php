<?php

declare(strict_types=1);

namespace Mds\Moncash;

use Mds\Moncash\Exception\InvalidPaymentRequestException;

final readonly class PaymentRequest
{
    /**
     * @param  string  $orderId  Order Id provided by your app
     * @param  float  $amount  Amount to be paid
     */
    public function __construct(
        /**
         * orderId - Order Id
         */
        private string $orderId,
        /**
         * amount - Amount
         */
        private float $amount
    ) {}

    /**
     * from - Create a new PaymentRequest instance from Array
     *
     * @param  array<string, mixed>  $payment  Payment Request Array
     * @return PaymentRequest PaymentRequest Object
     *
     * @throws InvalidPaymentRequestException
     */
    public static function from(array $payment): PaymentRequest
    {
        if (! isset($payment['orderId']) || empty($payment['orderId'])) {
            throw new InvalidPaymentRequestException('Missing `orderId` in payment request array');
        }

        if (! isset($payment['amount']) || empty($payment['amount'])) {
            throw new InvalidPaymentRequestException('Missing `amount` in payment request array');
        }

        if (! is_numeric($payment['amount']) || $payment['amount'] <= 0) {
            throw new InvalidPaymentRequestException('Invalid `amount` in payment request array');
        }

        return new self(
            (string) $payment['orderId'],
            (float) $payment['amount']
        );
    }

    /**
     * getOrderId - Get Order Id
     *
     * @return string Order Id provided by your app
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * getAmount - Get Amount
     *
     * @return float Amount to be paid
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * toArray - Convert Payment Request Object to Array
     *
     * @return array{orderId: string, amount: float} Payment Request as Array
     */
    public function toArray(): array
    {
        return [
            'orderId' => $this->orderId,
            'amount' => $this->amount,
        ];
    }
}
