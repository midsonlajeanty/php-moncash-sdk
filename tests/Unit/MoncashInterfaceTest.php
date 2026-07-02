<?php

declare(strict_types=1);

use Mds\Moncash\Moncash;
use Mds\Moncash\MoncashInterface;
use Mds\Moncash\TransactionDetails;
use Mockery\MockInterface;

test('Moncash implements MoncashInterface', function (): void {
    expect(class_implements(Moncash::class))->toContain(MoncashInterface::class);
});

test('MoncashInterface can stand in for the gateway as a test double', function (): void {
    $details = new TransactionDetails((object) [
        'reference' => 'order1',
        'transaction_id' => 'tx1',
        'cost' => 100.0,
        'payer' => '509xxxxxxxx',
        'message' => 'successful',
    ]);

    /** @var MoncashInterface&MockInterface $gateway */
    $gateway = Mockery::mock(MoncashInterface::class);
    $gateway->shouldReceive('getTransactionDetailsByOrderId')
        ->once()
        ->with('order1')
        ->andReturn($details);

    expect($gateway)->toBeInstanceOf(MoncashInterface::class);
    expect($gateway->getTransactionDetailsByOrderId('order1'))->toBe($details);
});
