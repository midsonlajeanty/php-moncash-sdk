<?php

namespace Mds\Moncashify;

use Mds\Moncashify\Core\Constants;

class Payment{

    private $orderId;
    private $amount;
    private $gateway;

    public function __construct(string $orderId, float|int $amount, object $gateway){
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->gateway = $gateway;
    }

    public function getOrderId(){
        return $this->orderId;
    }

    public function getAmount(){
        return $this->amount;
    }

    public function getToken(){
        return $this->gateway->token;
    }

    public function getRedirect(){
        return $this->gateway->base . Constants::$REDIRECT_URI . $this->gateway->token;
    }
}