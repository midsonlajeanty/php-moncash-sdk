<?php

declare(strict_types=1);

use Mds\Moncash\Config;
use Mds\Moncash\Exception\InvalidConfigException;

test('config object creation', function (): void {
    $config = new Config('client-id', 'client-secret');
    expect($config->getClientId())->toBe('client-id');
    expect($config->getClientSecret())->toBe('client-secret');
});

test('config from array', function (): void {
    $config = Config::from([
        'clientId' => 'client-id',
        'clientSecret' => 'client-secret',
    ]);
    expect($config->getClientId())->toBe('client-id');
    expect($config->getClientSecret())->toBe('client-secret');
    expect($config->toArray())->toBe([
        'clientId' => 'client-id',
        'clientSecret' => 'client-secret',
    ]);
});

test('config from array missing key throws InvalidConfigException', function (): void {
    expect(fn(): \Mds\Moncash\Config => Config::from(['clientId' => 'only-id']))->toThrow(InvalidConfigException::class);
});
