<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

require __DIR__ . '/constant.php';


use Mds\Moncash\Config;
use Mds\Moncash\Moncash;
use Mds\Moncash\PaymentRequest;

// Create Config and Moncash Instance
$config = new Config(CLIENT_ID, CLIENT_SECRET);
$moncash = new Moncash($config); // pass false as second arg for production

// Create Payment Request
$payment = new PaymentRequest(uniqid(), 100);

// Make Payment
$response = $moncash->makePayment($payment);
var_dump($response->getRedirect());

// Get Transaction Details by TransactionId provided by Moncash.
// $details = $moncash->getTransactionDetailsByTransactionId('TRANSACTION_ID');

// Get Transaction Details by OrderId provided by your app.
// $details = $moncash->getTransactionDetailsByOrderId('ORDER_ID');


// var_dump($details);
