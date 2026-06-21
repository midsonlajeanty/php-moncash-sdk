<?php

declare(strict_types=1);

use Mds\Moncash\Exception\ApiException;
use Mds\Moncash\Exception\InvalidConfigException;
use Mds\Moncash\Exception\InvalidPaymentRequestException;
use Mds\Moncash\Exception\MoncashException;

it('exception hierarchy extends base MoncashException', function (): void {
    expect(new InvalidConfigException('x'))->toBeInstanceOf(MoncashException::class);
    expect(new InvalidPaymentRequestException('x'))->toBeInstanceOf(MoncashException::class);
    expect(new ApiException('x'))->toBeInstanceOf(MoncashException::class);
});
