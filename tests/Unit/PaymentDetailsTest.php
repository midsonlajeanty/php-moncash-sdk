<?php

declare(strict_types=1);

use Mds\Moncash\Core\PaymentStatus;
use Mds\Moncash\PaymentDetails;

it('legacy PaymentDetails alias still works', function (): void {
    $data = (object) [
        'reference' => '123',
        'transaction_id' => 'abc123',
        'cost' => 100.50,
        'payer' => '1234567890',
        'message' => PaymentStatus::SUCCESSFUL,
    ];

    $details = new PaymentDetails($data);

    expect($details)->toBeInstanceOf(\Mds\Moncash\TransactionDetails::class);
    expect($details->getOrderId())->toBe('123');
    expect($details->getCost())->toBe(100.50); // deprecated accessor, delegates to getAmount()
    expect($details->isSuccessful())->toBeTrue();
});
