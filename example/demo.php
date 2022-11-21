<?php 

require 'vendor/autoload.php';

use Mds\Moncashify\Moncash;

$clientId = 'aaeeea83aaa4795aed751a2e766ea446';
$secret = 'aDcuzvpY6JIcMy7xR4VEWEE8CReP-VtDwO8i6uy8dHAIOm1G0M_2g_nG7nh2dHTT';

// Create Moncash Instance
$moncash = new Moncash($clientId, $secret);

// Make Paiment with OrderId and Amount
// $payment = $moncash->makePayment('ORDER332732', 100);

// var_dump($payment->getRedirect());


// Get Payment Details with TransactionId provided by Moncash.
// $details = $moncash->getPaymentDetails('2186189264');

// Get Payment Details with OrderId provided by your app.
// $details = $moncash->getPaymentDetails('ORDER332732', 'order');

// var_dump($details);