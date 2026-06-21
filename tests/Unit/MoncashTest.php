<?php

declare(strict_types=1);

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mds\Moncash\Config;
use Mds\Moncash\Core\PaymentStatus;
use Mds\Moncash\Moncash;
use Mds\Moncash\PaymentRequest;
use Mds\Moncash\PaymentResponse;
use Mds\Moncash\TransactionDetails;

function fakeMoncash(ClientInterface $client): Moncash
{
    $moncash = new Moncash(new Config('id', 'secret'), true);
    $moncash->setClient($client);

    return $moncash;
}

it('makePayment returns a PaymentResponse', function (): void {
    $client = Mockery::mock(ClientInterface::class);
    // 1st call: OAuth token (lazy auth)
    $client->shouldReceive('request')->once()
        ->with('POST', Mockery::pattern('/oauth\/token$/'), Mockery::any())
        ->andReturn(new Response(200, [], json_encode([
            'access_token' => 'tok', 'token_type' => 'Bearer',
        ])));
    // 2nd call: CreatePayment
    $client->shouldReceive('request')->once()
        ->with('POST', Mockery::pattern('/CreatePayment$/'), Mockery::any())
        ->andReturn(new Response(200, [], json_encode([
            'payment_token' => ['token' => 'abc', 'expired' => '2030-01-01 00:00:00'],
        ])));

    $response = fakeMoncash($client)->makePayment(new PaymentRequest('ORDER-1', 100.0));

    expect($response)->toBeInstanceOf(PaymentResponse::class);
    expect($response->getToken())->toBe('abc');
});

it('getTransactionDetailsByOrderId returns TransactionDetails', function (): void {
    $client = Mockery::mock(ClientInterface::class);
    $client->shouldReceive('request')->once()
        ->with('POST', Mockery::pattern('/oauth\/token$/'), Mockery::any())
        ->andReturn(new Response(200, [], json_encode([
            'access_token' => 'tok', 'token_type' => 'Bearer',
        ])));
    $client->shouldReceive('request')->once()
        ->with('POST', Mockery::pattern('/RetrieveOrderPayment$/'), Mockery::any())
        ->andReturn(new Response(200, [], json_encode([
            'payment' => [
                'reference' => 'ORDER-1', 'transaction_id' => 'tx1',
                'cost' => 100.0, 'payer' => '50912345678', 'message' => PaymentStatus::SUCCESSFUL,
            ],
        ])));

    $details = fakeMoncash($client)->getTransactionDetailsByOrderId('ORDER-1');

    expect($details)->toBeInstanceOf(TransactionDetails::class);
    expect($details->getOrderId())->toBe('ORDER-1');
    expect($details->isSuccessful())->toBeTrue();
});
