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

```
composer require midsonlajeanty/php-moncash-sdk 
```

## Usage

### Init Payment and get Payment URL  (Moncash Checkout)

```php
// Init Payment
use Mds\Moncash\Moncash;

// Create Moncash Instance
$moncash = new Moncash(CLIENT_ID, CLIENT_SECRET);

// Make Paiment with OrderId and Amount
$payment = $moncash->makePayment('ORDER-001', 100);

// Get Payment URL  (Moncash Checkout)
$payment->getRedirect();
```

### Get Transaction Details by Transaction and Order ID

```php
// Init Payment
use Mds\Moncash\Moncash;

// Create Moncash Instance
$moncash = new Moncash(CLIENT_ID, CLIENT_SECRET);

// Get Payment Details with TransactionId provided by Moncash.
$details = $moncash->getPaymentDetailsByTransactionId('TRANSACTION_ID');

// Get Payment Details with OrderId provided by your app.
$details = $moncash->getPaymentDetailsByOrderId('ORDER_ID');
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

## Contributing

You have a lot of options to contribute to this project ! You can :

- [Fork](https://github.com/midsonlajeanty/php-moncash-sdk) on Github
- [Submit](https://github.com/midsonlajeanty/php-moncash-sdk/issues) a bug report.
- [Donate](https://www.buymeacoffee.com/midsonlajeanty) to the Developper
