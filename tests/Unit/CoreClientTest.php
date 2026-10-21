<?php

declare(strict_types=1);

use GuzzleHttp\ClientInterface;
use Mds\Moncash\Config;
use Mds\Moncash\Core\Constants;
use Mds\Moncash\Moncash;

it('allows injecting a Guzzle client without triggering auth in constructor', function (): void {
    $config = new Config('id', 'secret');
    // The constructor must NOT make any network call (lazy auth).
    $moncash = new Moncash($config, true);

    $client = Mockery::mock(ClientInterface::class);
    $moncash->setClient($client);

    expect($moncash->getClient())->toBe($client);
});

it('bounds the default Guzzle client with a timeout and a connect timeout', function (): void {
    $client = (new Moncash(new Config('id', 'secret')))->getClient();

    expect($client->getConfig('timeout'))->toBe(Constants::DEFAULT_TIMEOUT)
        ->and($client->getConfig('connect_timeout'))->toBe(Constants::DEFAULT_CONNECT_TIMEOUT);
});
