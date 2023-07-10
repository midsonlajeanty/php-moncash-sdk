<?php

require '../vendor/autoload.php';

require 'constant.php';


use Mds\Moncash\Moncash;

if (isset($_GET['transactionId'])) {

    $transactionId = $_GET['transactionId'];

    // Create Moncash Instance
    $moncash = new Moncash(CLIENT_ID, CLIENT_SECRET);

    // Retrieve Transaction by transactionId
    try {
        $payment = $moncash->getPaymentDetailsByTransactionId($transactionId);
    } catch (\Exception $e) {
        $errors = $e->getMessage();
    }
} else {
    // redirect to hone
    header("Location: /");
    http_response_code(302);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Moncash SDK - Demo</title>

    <link rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" 
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" 
        crossorigin="anonymous"
    >
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="container px-3 my-5 clearfix">
        <!-- Shopping cart table -->
        <?php if (isset($payment)) : ?>
            <div class="alert alert-success">
                Transaction Success
            </div>
        <?php else : ?>
            <div class="alert alert-danger">
                Transaction Failed
            </div>
        <?php endif; ?>

        <?php if (isset($payment)) : ?>
            <div class="card">
                <div class="card-header">
                    <h2>Transaction Details</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered m-0">
                            <tbody>
                                <tr>
                                    <td class="text-center align-middle p-4">
                                        <span>Transaction ID : </span>
                                        <span><?= $payment->getTransactionId() ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center align-middle p-4">
                                        <span>Order ID : </span>
                                        <span><?= $payment->getOrderId() ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center align-middle p-4">
                                        <span>Cost : </span>
                                        <span><?= $payment->getCost() ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center align-middle p-4">
                                        <span>Payer : </span>
                                        <span><?= $payment->getPayer() ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="text-center align-middle p-4">
                                        <span>Status : </span>
                                        <span><?= $payment->getStatus() ?></span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script 
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" 
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" 
        crossorigin="anonymous">
    </script>

    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" 
        integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" 
        crossorigin="anonymous">
    </script>

</body>

</html>