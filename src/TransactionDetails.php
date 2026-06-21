<?php

declare(strict_types=1);

namespace Mds\Moncash;

use Mds\Moncash\Core\PaymentStatus;

class TransactionDetails
{
    /**
     * orderId - OrderId provided by your app.
     */
    private string $orderId;

    /**
     * transactionId - TransactionId provided by Moncash.
     */
    private string $transactionId;

    /**
     * amount - Amount paid by the payer.
     */
    private float $amount;

    /**
     * payer - Payer's phone number.
     */
    private string $payer;

    /**
     * status - Raw status of the payment.
     */
    private string $status;

    /**
     * @param  object  $data  Payment details provided by Moncash.
     */
    public function __construct(object $data)
    {
        $this->orderId = (string) $data->reference;
        $this->transactionId = (string) $data->transaction_id;
        $this->amount = (float) $data->cost;
        $this->payer = (string) $data->payer;
        $this->status = (string) $data->message;
    }

    /**
     * fromResponse - Create TransactionDetails Object from Response
     *
     * @param  \Psr\Http\Message\ResponseInterface  $res  Response from Moncash
     * @return TransactionDetails TransactionDetails Object
     */
    public static function fromResponse(\Psr\Http\Message\ResponseInterface $res): TransactionDetails
    {
        $data = json_decode((string) $res->getBody());

        return new self($data->payment);
    }

    /**
     * getOrderId - Get OrderId
     *
     * @return string OrderId provided by your app
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * getTransactionId - Get TransactionId
     *
     * @return string TransactionId provided by Moncash
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * getAmount - Get Amount paid by the payer
     *
     * @return float Amount paid by the payer
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * getCost - Deprecated, use getAmount() instead
     *
     * @return float Amount paid by the payer
     *
     * @deprecated Use getAmount() instead.
     */
    public function getCost(): float
    {
        @trigger_error('getCost() is deprecated, use getAmount() instead.', E_USER_DEPRECATED);

        return $this->getAmount();
    }

    /**
     * getPayer - Get Payer
     *
     * @return string Payer's phone number
     */
    public function getPayer(): string
    {
        return $this->payer;
    }

    /**
     * getStatus - Get raw payment status
     *
     * @return string Status of the payment
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * isSuccessful - Verify Status
     *
     * @return bool Payment successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === PaymentStatus::SUCCESSFUL;
    }

    /**
     * toArray - Transaction Details to Array
     *
     * @return array{orderId: string, transactionId: string, amount: float, payer: string, isSuccessful: bool} Transaction Details
     */
    public function toArray(): array
    {
        return [
            'orderId' => $this->orderId,
            'transactionId' => $this->transactionId,
            'amount' => $this->amount,
            'payer' => $this->payer,
            'isSuccessful' => $this->isSuccessful(),
        ];
    }
}

\class_alias(TransactionDetails::class, \Mds\Moncash\PaymentDetails::class);
