<?php

require '../vendor/autoload.php';

require 'constant.php';


use Mds\Moncash\Moncash;

if (isset($_POST['create_payment'])) {

    $orderId = $_POST['order_id'];
    $amount = $_POST['amount'];

    // Create Moncash Instance
    $moncash = new Moncash(CLIENT_ID, CLIENT_SECRET);

    // Make Paiment with OrderId and Amount
    $payment = $moncash->makePayment($orderId, $amount);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Moncash SDK - Demo</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <style>
        body {
            margin-top: 20px;
            background: #eee;
        }

        .ui-w-40 {
            width: 40px !important;
            height: auto;
        }

        .card {
            box-shadow: 0 1px 15px 1px rgba(52, 40, 104, 0.08);
        }

        .ui-product-color {
            display: inline-block;
            overflow: hidden;
            margin: 0.144em;
            width: 0.875rem;
            height: 0.875rem;
            border-radius: 10rem;
            -webkit-box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, 0.15) inset;
            vertical-align: middle;
        }
    </style>

</head>

<body>
    <div class="container px-3 my-5 clearfix">
        <!-- Shopping cart table -->
        <div class="card">
            <div class="card-header">
                <h2>Shopping Cart</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <!-- Set columns width -->
                                <th class="text-center py-3 px-4" style="min-width: 400px;">Product Name &amp; Details</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Price</th>
                                <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                                <th class="text-right py-3 px-4" style="width: 100px;">Total</th>
                                <th class="text-center align-middle py-3 px-0" style="width: 40px;"><a href="#" class="shop-tooltip float-none text-light" title="" data-original-title="Clear cart"><i class="ino ion-md-trash"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td class="p-4">
                                    <div class="media align-items-center">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="d-block ui-w-40 ui-bordered mr-4" alt="">
                                        <div class="media-body">
                                            <a href="#" class="d-block text-dark">Product 1</a>
                                            <small>
                                                <span class="text-muted">Color:</span>
                                                <span class="ui-product-color ui-product-color-sm align-text-bottom" style="background:#e81e2c;"></span> &nbsp;
                                                <span class="text-muted">Size: </span> EU 37 &nbsp;
                                                <span class="text-muted">Ships from: </span> China
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right font-weight-semibold align-middle p-4">HTG 57.55</td>
                                <td class="align-middle p-4"><input type="text" class="form-control text-center" value="2"></td>
                                <td class="text-right font-weight-semibold align-middle p-4">HTG 115.1</td>
                                <td class="text-center align-middle px-0"><a href="#" class="shop-tooltip close float-none text-danger" title="" data-original-title="Remove">×</a></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <!-- / Shopping cart table -->

                <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                    <div class="mt-4"></div>
                    <div class="d-flex">
                        <div class="text-right mt-4 mr-5">
                            <label class="text-muted font-weight-normal m-0">Discount</label>
                            <div class="text-large"><strong>HTG 20</strong></div>
                        </div>
                        <div class="text-right mt-4">
                            <label class="text-muted font-weight-normal m-0">Total price</label>
                            <div class="text-large"><strong>HTG 1164.65</strong></div>
                        </div>
                    </div>
                </div>

                <form action="" method="post">

                    <input type="hidden" name="amount" value="100">
                    <input type="hidden" name="order_id" value="<?= time() ?> ">

                    <div class="float-right">
                        <?php if (isset($payment)) : ?>
                            <!-- Redirect to Payment URL -->
                            <a href="<?= $payment->getRedirect() ?>" type="button" class="btn btn-lg btn-danger">Pay</a>
                        <?php else : ?>
                            <!-- Generate Payment URL -->
                            <button type="submit" name="create_payment" class="btn btn-lg btn-primary mt-2">Checkout</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>

</html>