<?php

require 'vendor/autoload.php';

require 'constant.php';


use Mds\Moncash\Moncash;


// Create Moncash Instance
$moncash = new Moncash(CLIENT_ID, CLIENT_SECRET);

// Make Paiment with OrderId and Amount
$payment = $moncash->makePayment(time(), 100);
var_dump($payment->getRedirect());

// Get Payment Details with TransactionId provided by Moncash.
// $details = $moncash->getPaymentDetailsByTransactionId('TRANSACTION_ID');

// Get Payment Details with OrderId provided by your app.
// $details = $moncash->getPaymentDetailsByOrderId('ORDER_ID');


// var_dump($details);
