<?php

declare(strict_types=1);

use GuzzleHttp\Psr7\Stream;
use Mds\Moncash\Core\PaymentStatus;
use Mds\Moncash\TransactionDetails;

it('creates transaction details with constructor', function (): void {
    $data = (object) [
        'reference' => '123',
        'transaction_id' => 'abc123',
        'cost' => 100.50,
        'payer' => '1234567890',
        'message' => PaymentStatus::SUCCESSFUL,
    ];

    $details = new TransactionDetails($data);

    expect($details->getOrderId())->toBe('123');
    expect($details->getTransactionId())->toBe('abc123');
    expect($details->getAmount())->toBe(100.50);
    expect($details->getPayer())->toBe('1234567890');
    expect($details->getStatus())->toBe(PaymentStatus::SUCCESSFUL);
    expect($details->isSuccessful())->toBeTrue();
    expect($details->toArray())->toBe([
        'orderId' => '123',
        'transactionId' => 'abc123',
        'amount' => 100.50,
        'payer' => '1234567890',
        'isSuccessful' => true,
    ]);
});

it('creates transaction details from response interface', function (): void {
    $responseData = (object) [
        'payment' => (object) [
            'reference' => '456',
            'transaction_id' => 'def456',
            'cost' => 200.75,
            'payer' => '0987654321',
            'message' => PaymentStatus::SUCCESSFUL,
        ],
    ];

    $response = Mockery::mock(\Psr\Http\Message\ResponseInterface::class);
    $response->shouldReceive('getBody')->andReturn(
        new Stream(fopen('data://text/plain,' . json_encode($responseData), 'r'))
    );

    $details = TransactionDetails::fromResponse($response);

    expect($details)->toBeInstanceOf(TransactionDetails::class);
    expect($details->getOrderId())->toBe('456');
    expect($details->getAmount())->toBe(200.75);
    expect($details->isSuccessful())->toBeTrue();
});
