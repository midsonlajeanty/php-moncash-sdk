<?php

declare(strict_types=1);

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
