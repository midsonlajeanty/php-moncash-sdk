<?php

namespace Mds\Moncash;

class PaymentDetails
{

    /**
     * orderId - OrderId provided by your app.
     *
     * @var string
     */
    private $orderId;

    /**
     * transactionId - TransactionId provided by Moncash.
     *
     * @var string
     */
    private $transactionId;

    /**
     * cost - Amount paid by the payer.
     *
     * @var float|int
     */
    private $cost;

    /**
     * payer - Payer's phone number.
     *
     * @var string
     */
    private $payer;

    /**
     * status - Status of the payment.
     *
     * @var string
     */
    private $status;

    /**
     * __construct - Create PaymentDetails Object
     *
     * @param  object $data Payment Details provided by Moncash.
     * 
     * @return void
     */
    public function __construct(object $data)
    {
        $this->orderId = $data->reference;
        $this->transactionId = $data->transaction_id;
        $this->cost = $data->cost;
        $this->payer = $data->payer;
        $this->status = $data->message;
    }

    /**
     * fromResponse - Create PaymentDetails Object from Response
     *
     * @param  \Psr\Http\Message\ResponseInterface $res Response from Moncash
     * 
     * @return PaymentDetails PaymentDetails Object
     */
    public static function fromResponse(\Psr\Http\Message\ResponseInterface $res)
    {
        $data = json_decode($res->getBody());

        return new self($data->payment);
    }

    /**
     * getOrderId - Get OrderId
     *
     * @return string OrderId provided by your app
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * getTransactionId - Get TransactionId
     *
     * @return string TransactionId provided by Moncash
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * getCost - Get Cost
     *
     * @return float|int Amount paid by the payer.
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * getPayer - Get Payer
     *
     * @return string Payer's phone number
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * getStatus - Get Status
     *
     * @return string Status of the payment
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * isSuccessful - Verify Status
     *
     * @return string Payment Sucessfull
     */
    public function isSuccessful()
    {
        return $this->status == 'successful';
    }

    /**
     * toArray - Payment Details to Array
     *
     * @return array Payment Details
     */
    public function toArray()
    {
        return [
            'orderId' => $this->orderId,
            'transactionId' => $this->transactionId,
            'cost' => $this->cost,
            'payer' => $this->payer,
            'status' => $this->status,
        ];
    }
}
