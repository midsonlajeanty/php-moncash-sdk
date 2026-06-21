<?php

declare(strict_types=1);

use Mds\Moncash\Core\Constants;
use Mds\Moncash\PaymentResponse;

test('payment response object test', function (): void {
    $expireAt = new \DateTime('2024-05-10');
    $response = new PaymentResponse('123', 100.50, 'abc123', $expireAt, 'https://example.com/');

    expect($response->getOrderId())->toBe('123');
    expect($response->getAmount())->toBe(100.50);
    expect($response->getToken())->toBe('abc123');
    expect($response->getExpiresAt())->toBe($expireAt);
    expect($response->getRedirect())->toBe('https://example.com/' . Constants::REDIRECT_URI . 'abc123');
});

test('Payment alias still resolves to PaymentResponse', function (): void {
    expect(class_exists(\Mds\Moncash\Payment::class))->toBeTrue();
    $payment = new \Mds\Moncash\Payment('1', 1.0, 't', new \DateTime(), 'https://g/');
    expect($payment)->toBeInstanceOf(PaymentResponse::class);
});
