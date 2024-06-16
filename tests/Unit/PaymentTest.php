<?php

use Mds\Moncash\Payment;
use Mds\Moncash\Core\Constants;

test('payment object test', function () {
    $orderId = '123';
    $amount = 100.50;
    $token = 'abc123';
    $expireAt = new \DateTime('2024-05-10');
    $gateway = 'https://example.com/';

    $payment = new Payment(
        orderId: $orderId, 
        amount: $amount, 
        token: $token, 
        expireAt: $expireAt, 
        gateway:$gateway
    );

    expect($payment->getOrderId())->tobe($orderId);
    expect($payment->getAmount())->tobe($amount);
    expect($payment->getToken())->tobe($token);
    expect($payment->getExpireAt())->tobe($expireAt);
    expect($payment->getRedirect())->tobe($gateway . Constants::REDIRECT_URI . $token);
});
