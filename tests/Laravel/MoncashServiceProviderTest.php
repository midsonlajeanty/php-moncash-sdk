<?php

declare(strict_types=1);

use Mds\Moncash\Core\Constants;
use Mds\Moncash\Exception\InvalidConfigException;
use Mds\Moncash\Laravel\Facades\Moncash;
use Mds\Moncash\Moncash as MoncashGateway;
use Mds\Moncash\MoncashInterface;

test('the container resolves a configured MonCash gateway', function (): void {
    expect(app(MoncashInterface::class))->toBeInstanceOf(MoncashGateway::class);
});

test('the gateway is a singleton reachable through the moncash alias', function (): void {
    expect(app('moncash'))->toBe(app(MoncashInterface::class));
});

test('the facade proxies to the bound gateway', function (): void {
    expect(Moncash::getFacadeRoot())->toBeInstanceOf(MoncashGateway::class);
});

test('the resolved client carries the configured timeouts', function (): void {
    config()->set('moncash.timeout', 7.5);
    config()->set('moncash.connect_timeout', 3);

    $client = app(MoncashInterface::class)->getClient();

    expect($client->getConfig('timeout'))->toBe(7.5)
        ->and($client->getConfig('connect_timeout'))->toBe(3.0);
});

test('the resolved client falls back to the default timeouts', function (): void {
    config()->set('moncash', [
        'client_id' => 'test-client-id',
        'client_secret' => 'test-client-secret',
    ]);

    $client = app(MoncashInterface::class)->getClient();

    expect($client->getConfig('timeout'))->toBe((float) Constants::DEFAULT_TIMEOUT)
        ->and($client->getConfig('connect_timeout'))->toBe((float) Constants::DEFAULT_CONNECT_TIMEOUT);
});

test('resolving the gateway without a client id throws', function (string $value): void {
    config()->set('moncash.client_id', $value);

    app(MoncashInterface::class);
})->with(['empty' => '', 'blank' => '   '])->throws(InvalidConfigException::class, 'moncash.client_id');

test('resolving the gateway without a client secret throws', function (): void {
    config()->set('moncash.client_secret', '');

    app(MoncashInterface::class);
})->throws(InvalidConfigException::class, 'moncash.client_secret');
