<?php

declare(strict_types=1);

use Mds\Moncash\Core\Constants;
use Mds\Moncash\Payment;

test('legacy Payment alias still works', function (): void {
    $expireAt = new \DateTime('2024-05-10');
    $payment = new Payment('123', 100.50, 'abc123', $expireAt, 'https://example.com/');

    expect($payment->getOrderId())->toBe('123');
    expect($payment->getAmount())->toBe(100.50);
    expect($payment->getToken())->toBe('abc123');
    expect($payment->getRedirect())->toBe('https://example.com/' . Constants::REDIRECT_URI . 'abc123');
});
