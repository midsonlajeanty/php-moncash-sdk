<?php

declare(strict_types=1);

use Mds\Moncash\Exception\InvalidPaymentRequestException;
use Mds\Moncash\PaymentRequest;

test('payment request object creation', function (): void {
    $req = new PaymentRequest('ORDER-1', 100.0);
    expect($req->getOrderId())->toBe('ORDER-1');
    expect($req->getAmount())->toBe(100.0);
    expect($req->toArray())->toBe(['orderId' => 'ORDER-1', 'amount' => 100.0]);
});

test('payment request from array', function (): void {
    $req = PaymentRequest::from(['orderId' => 'ORDER-2', 'amount' => 50]);
    expect($req->getOrderId())->toBe('ORDER-2');
    expect($req->getAmount())->toBe(50.0);
});

test('payment request from array invalid amount throws', function (): void {
    expect(fn(): \Mds\Moncash\PaymentRequest => PaymentRequest::from(['orderId' => 'ORDER-3', 'amount' => 0]))->toThrow(InvalidPaymentRequestException::class);
});

test('payment request from array missing orderId throws', function (): void {
    expect(fn(): \Mds\Moncash\PaymentRequest => PaymentRequest::from(['amount' => 10]))->toThrow(InvalidPaymentRequestException::class);
});
