<?php

declare(strict_types=1);

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mds\Moncash\Config;
use Mds\Moncash\Moncash;
use Mds\Moncash\PaymentResponse;
use Mds\Moncash\TransactionDetails;

it('deprecated constructor emits E_USER_DEPRECATED and returns Moncash instance', function (): void {
    $deprecationCaught = false;
    set_error_handler(function (int $errno, string $errstr) use (&$deprecationCaught): bool {
        if ($errno === E_USER_DEPRECATED) {
            $deprecationCaught = true;
        }

        return true;
    });

    $moncash = new Moncash('id', 'secret', true);

    restore_error_handler();

    expect($moncash)->toBeInstanceOf(Moncash::class);
    expect($deprecationCaught)->toBeTrue();
});

it('deprecated makePayment with orderId/amount routes to DTO and returns PaymentResponse', function (): void {
    $client = Mockery::mock(ClientInterface::class);
    $client->shouldReceive('request')->once()
        ->with('POST', Mockery::pattern('/oauth\/token$/'), Mockery::any())
        ->andReturn(new Response(200, [], json_encode([
            'access_token' => 'tok', 'token_type' => 'Bearer',
        ])));
    $client->shouldReceive('request')->once()
        ->with('POST', Mockery::pattern('/CreatePayment$/'), Mockery::any())
        ->andReturn(new Response(200, [], json_encode([
            'payment_token' => ['token' => 'abc', 'expired' => '2030-01-01 00:00:00'],
        ])));

    $moncash = new Moncash(new Config('id', 'secret'), true);
    $moncash->setClient($client);

    // Suppress deprecation warning for legacy call
    $response = @$moncash->makePayment('ORDER-COMPAT', 150.0);

    expect($response)->toBeInstanceOf(PaymentResponse::class);
    expect($response->getToken())->toBe('abc');
});

it('alias Mds\\Moncash\\Payment exists and is instanceof PaymentResponse', function (): void {
    expect(class_exists(\Mds\Moncash\Payment::class))->toBeTrue();

    $expireAt = new \DateTime('2030-01-01');
    $instance = new PaymentResponse('order-1', 100.0, 'tok', $expireAt, 'https://gateway.example.com');

    expect($instance)->toBeInstanceOf(\Mds\Moncash\Payment::class);
});

it('alias Mds\\Moncash\\PaymentDetails exists and is instanceof TransactionDetails', function (): void {
    expect(class_exists(\Mds\Moncash\PaymentDetails::class))->toBeTrue();

    $data = (object) [
        'reference' => 'ORDER-1',
        'transaction_id' => 'TX-1',
        'cost' => 100.0,
        'payer' => '50912345678',
        'message' => 'successful',
    ];
    $instance = new TransactionDetails($data);

    expect($instance)->toBeInstanceOf(\Mds\Moncash\PaymentDetails::class);
});

it('Config::fromArray() emits E_USER_DEPRECATED and returns valid Config', function (): void {
    $deprecationCaught = false;
    $deprecationMessage = '';
    set_error_handler(function (int $errno, string $errstr) use (&$deprecationCaught, &$deprecationMessage): bool {
        if ($errno === E_USER_DEPRECATED) {
            $deprecationCaught = true;
            $deprecationMessage = $errstr;
        }

        return true;
    });

    $config = Config::fromArray(['clientId' => 'test-id', 'clientSecret' => 'test-secret']);

    restore_error_handler();

    expect($deprecationCaught)->toBeTrue();
    expect($deprecationMessage)->toContain('Config::fromArray()');
    expect($config)->toBeInstanceOf(Config::class);
    expect($config->getClientId())->toBe('test-id');
    expect($config->getClientSecret())->toBe('test-secret');
});

it('PaymentRequest::fromArray() emits E_USER_DEPRECATED and returns valid PaymentRequest', function (): void {
    $deprecationCaught = false;
    $deprecationMessage = '';
    set_error_handler(function (int $errno, string $errstr) use (&$deprecationCaught, &$deprecationMessage): bool {
        if ($errno === E_USER_DEPRECATED) {
            $deprecationCaught = true;
            $deprecationMessage = $errstr;
        }

        return true;
    });

    $req = \Mds\Moncash\PaymentRequest::fromArray(['orderId' => 'ORDER-BC', 'amount' => 75.0]);

    restore_error_handler();

    expect($deprecationCaught)->toBeTrue();
    expect($deprecationMessage)->toContain('PaymentRequest::fromArray()');
    expect($req)->toBeInstanceOf(\Mds\Moncash\PaymentRequest::class);
    expect($req->getOrderId())->toBe('ORDER-BC');
    expect($req->getAmount())->toBe(75.0);
});
