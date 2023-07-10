Minimum SDK to process payment with Digicel Moncash

## Features

- Init Moncash Payment and get Payment URL  (Moncash Checkout)
- Get Transaction Details by Transaction and Order ID

## Getting started

```
composer require mds/php-moncash-sdk 
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

## Contributing

You have a lot of options to contribute to this project ! You can :

- [Fork](https://github.com/midsonlajeanty/php-moncash-sdk) on Github
- [Submit](https://github.com/midsonlajeanty/php-moncash-sdk/issues) a bug report.
- [Donate](https://www.buymeacoffee.com/midsonlajeanty) to the Developper
