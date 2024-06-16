<?php

use GuzzleHttp\Psr7\Stream;
use Mds\Moncash\PaymentDetails;

it('create payment details with constructor', function () {
    $data = (object) [
        'reference' => '123',
        'transaction_id' => 'abc123',
        'cost' => 100.50,
        'payer' => '1234567890',
        'message' => 'successful',
    ];

    $paymentDetails = new PaymentDetails($data);

    expect($paymentDetails->getOrderId())->toBe($data->reference);

    expect($paymentDetails->getTransactionId())->toBe($data->transaction_id);

    expect($paymentDetails->getCost())
        ->toBeNumeric()
        ->toBe($data->cost);

    expect($paymentDetails->getPayer())
        ->toBeNumeric()
        ->toBe($data->payer);

    expect($paymentDetails->getStatus())->toBe($data->message);

    expect($paymentDetails->isSuccessful())->toBeTrue();

    expect($paymentDetails->toArray())
        ->toBeArray()
        ->toHaveKey('orderId', $data->reference)
        ->toHaveKey('transactionId', $data->transaction_id)
        ->toHaveKey('cost', $data->cost)
        ->toHaveKey('payer', $data->payer)
        ->toHaveKey('status', $data->message);
});

it('create payment details from response interface', function () {
    $data = (object) [
        'reference' => '456',
        'transaction_id' => 'def456',
        'cost' => 200.75,
        'payer' => '0987654321',
        'message' => 'successful',
    ];

    $responseData = (object) [
        'payment' => $data
    ];

    $response = Mockery::mock(\Psr\Http\Message\ResponseInterface::class);
    $response->shouldReceive('getBody')->andReturn(
        new Stream(fopen('data://text/plain,' . json_encode($responseData) ,'r'))
    );

    $paymentDetails = PaymentDetails::fromResponse($response);

    expect($paymentDetails)->toBeInstanceOf(PaymentDetails::class);

    expect($paymentDetails->getOrderId())->toBe($data->reference);

    expect($paymentDetails->getTransactionId())->toBe($data->transaction_id);

    expect($paymentDetails->getCost())
        ->toBeNumeric()
        ->toBe($data->cost);

    expect($paymentDetails->getPayer())
        ->toBeNumeric()
        ->toBe($data->payer);

    expect($paymentDetails->getStatus())->toBe($data->message);

    expect($paymentDetails->isSuccessful())->toBeTrue();

    expect($paymentDetails->toArray())
        ->toBeArray()
        ->toHaveKey('orderId', $data->reference)
        ->toHaveKey('transactionId', $data->transaction_id)
        ->toHaveKey('cost', $data->cost)
        ->toHaveKey('payer', $data->payer)
        ->toHaveKey('status', $data->message);
});
