<?php 

namespace Mds\Moncashify;

class PaymentDetails{

    private $orderId;
    private $transactionId;
    private $cost;
    private $payer;
    private $status;

    public function __construct($data)
    {
        $this->orderId = $data->reference;
        $this->transactionId = $data->transaction_id;
        $this->cost = $data->cost;
        $this->payer = $data->payer;
        $this->status = $data->message;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getPayer()
    {
        return $this->payer;
    }

    public function getStatus()
    {
        return $this->status;
    }
}