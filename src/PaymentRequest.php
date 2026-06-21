<?php

declare(strict_types=1);

namespace Mds\Moncash;

use Mds\Moncash\Exception\InvalidPaymentRequestException;

final class PaymentRequest
{
    /**
     * orderId - Order Id
     *
     * @var string Order Id provided by your app
     */
    private string $orderId;

    /**
     * amount - Amount
     *
     * @var float Amount to be paid
     */
    private float $amount;

    /**
     * @param  string  $orderId  Order Id provided by your app
     * @param  float  $amount  Amount to be paid
     */
    public function __construct(string $orderId, float $amount)
    {
        $this->orderId = $orderId;
        $this->amount = $amount;
    }

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
     * fromArray - Deprecated, use from() instead
     *
     * @param  array<string, mixed>  $payment  Payment Request Array
     * @return PaymentRequest PaymentRequest Object
     *
     * @deprecated Use PaymentRequest::from() instead.
     */
    public static function fromArray(array $payment): PaymentRequest
    {
        @trigger_error('PaymentRequest::fromArray() is deprecated, use PaymentRequest::from() instead.', E_USER_DEPRECATED);

        return self::from($payment);
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
