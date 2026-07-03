<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://moncashdfs.com/theme/images/logo.png" width="200" alt="Moncash Logo">
    </a>
</p>

<p align="center">
    <a href="https://github.com/midsonlajeanty/php-moncash-sdk/actions">
        <img src="https://github.com/midsonlajeanty/php-moncash-sdk/actions/workflows/tests.yml/badge.svg" alt="Build Status">
    </a>
    <a href="https://packagist.org/packages/midsonlajeanty/php-moncash-sdk">
        <img src="https://img.shields.io/packagist/dt/midsonlajeanty/php-moncash-sdk" alt="Total Downloads">
    </a>
    <a href="https://packagist.org/packages/midsonlajeanty/php-moncash-sdk">
        <img src="https://img.shields.io/packagist/v/midsonlajeanty/php-moncash-sdk" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/midsonlajeanty/php-moncash-sdk">
        <img src="https://img.shields.io/packagist/l/midsonlajeanty/php-moncash-sdk" alt="License">
    </a>
</p>


Minimum SDK to process payment with Digicel Moncash Payment Gateway

## Features

- Create Payment Transaction and get gateway URL  (Moncash Checkout)
- Get Transaction Details by Transaction and Order ID

## Getting started

Requires **PHP 8.2+**.

```
composer require midsonlajeanty/php-moncash-sdk
```

> **On PHP < 8.2?** Pin the 1.x line, which supports PHP 7.4+:
> ```
> composer require "midsonlajeanty/php-moncash-sdk:^1.0"
> ```

## Usage

### Init Payment and get Payment URL  (Moncash Checkout)

```php
use Mds\Moncash\Config;
use Mds\Moncash\Moncash;
use Mds\Moncash\PaymentRequest;

// Moncash Merchant Credentials
$config = new Config(CLIENT_ID, CLIENT_SECRET);

// Init SDK with config
$moncash = new Moncash($config, DEBUG);

// Make Payment with a payment request
$response = $moncash->makePayment(new PaymentRequest('ORDER-001', 100));

// Get Payment URL  (Moncash Checkout)
$response->getRedirect();
```

### Get Transaction Details by Transaction and Order ID

```php
use Mds\Moncash\Config;
use Mds\Moncash\Moncash;

// Create Moncash instance
$moncash = new Moncash(new Config(CLIENT_ID, CLIENT_SECRET));

// Get Transaction Details with TransactionId provided by Moncash.
$details = $moncash->getTransactionDetailsByTransactionId('TRANSACTION_ID');

// Get Transaction Details with OrderId provided by your app.
$details = $moncash->getTransactionDetailsByOrderId('ORDER_ID');
```

## Common conventions (MonCash & NatCash)

The MonCash and NatCash SDKs share the same pattern. Anyone familiar with one will feel at home with the other:

| Step | Class / method |
|---|---|
| Configuration | `new Config($clientId, $clientSecret)` |
| Instantiation | `new <Gateway>($config, $debug = true)` |
| Request | `new PaymentRequest($orderId, $amount)` |
| Payment | `makePayment(PaymentRequest): PaymentResponse` |
| Redirect | `$response->getRedirect()` |
| Details | `getTransactionDetailsByOrderId($orderId): TransactionDetails` |
| Result | `$details->getOrderId()`, `getTransactionId()`, `getAmount()`, `getPayer()`, `isSuccessful()` |

MonCash-specific: `getToken()`, `getTransactionDetailsByTransactionId()` (lookup by transaction ID).

## Laravel

The package auto-registers a service provider and a facade (Laravel 9 to 13). Publish the config file:

```bash
php artisan vendor:publish --tag=moncash-config
```

Set your credentials in `.env` (they are loaded automatically):

```dotenv
MONCASH_CLIENT_ID=your-client-id
MONCASH_CLIENT_SECRET=your-client-secret
# Sandbox gateway. Defaults to false (live); set true in local environments.
MONCASH_DEBUG=true
```

Then use the facade, or inject `MoncashInterface` (both resolve the same configured singleton):

```php
use Mds\Moncash\Laravel\Facades\Moncash;
use Mds\Moncash\PaymentRequest;

$response = Moncash::makePayment(new PaymentRequest('order-1', 250.0));

return redirect($response->getRedirect());
```

```php
use Mds\Moncash\MoncashInterface;

final class CheckoutController
{
    public function __construct(private MoncashInterface $moncash) {}
}
```

## Testing

The `Moncash` gateway is `final` (it is the only class that performs I/O), so it cannot be mocked directly. Instead, type-hint your application code against `MoncashInterface` and mock the interface:

```php
use Mds\Moncash\MoncashInterface;

final class CheckoutService
{
    public function __construct(private MoncashInterface $gateway) {}

    public function pay(PaymentRequest $request): PaymentResponse
    {
        return $this->gateway->makePayment($request);
    }
}

// Production: inject the real gateway.
new CheckoutService(new Moncash(new Config('clientId', 'clientSecret')));
```

```php
// Test: mock the interface, no need to hit the network.
$gateway = Mockery::mock(MoncashInterface::class);
$gateway->shouldReceive('makePayment')->once()->andReturn($fakeResponse);

$service = new CheckoutService($gateway);
```

Value objects (`Config`, `PaymentRequest`, `PaymentResponse`, `TransactionDetails`) are also `final` — don't mock them, just construct them with test data.

## Contributing

You have a lot of options to contribute to this project ! You can :

- [Fork](https://github.com/midsonlajeanty/php-moncash-sdk) on Github
- [Submit](https://github.com/midsonlajeanty/php-moncash-sdk/issues) a bug report.
- [Donate](https://www.buymeacoffee.com/midsonlajeanty) to the Developper
