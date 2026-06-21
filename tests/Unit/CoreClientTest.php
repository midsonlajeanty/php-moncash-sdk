<?php

declare(strict_types=1);

use GuzzleHttp\ClientInterface;
use Mds\Moncash\Config;
use Mds\Moncash\Moncash;

it('allows injecting a Guzzle client without triggering auth in constructor', function (): void {
    $config = new Config('id', 'secret');
    // The constructor must NOT make any network call (lazy auth).
    $moncash = new Moncash($config, true);

    $client = Mockery::mock(ClientInterface::class);
    $moncash->setClient($client);

    expect($moncash->getClient())->toBe($client);
});
