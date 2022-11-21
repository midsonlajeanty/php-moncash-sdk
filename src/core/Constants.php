<?php

namespace Mds\Moncashify\Core;

class Constants{

    static string $LIVE_URL = "https://moncashbutton.digicelgroup.com/Api";
    static string $SANDBOX_URL = "https://sandbox.moncashbutton.digicelgroup.com/Api";

    static string $LIVE_BASE_GATEWAY = 'https://moncashbutton.digicelgroup.com/Moncash-middleware';
    static string $SANDBOX_BASE_GATEWAY = 'https://sandbox.moncashbutton.digicelgroup.com/Moncash-middleware';

    static string $TOKEN_URI = '/oauth/token';
    static string $REDIRECT_URI = '/Payment/Redirect?token=';

    static string $PAYMENT_URI = '/v1/CreatePayment';
    static string $TRANSFERT_URI = '/v1/Transfert';
    static string $DETAILS_TRANSACTION_URI = '/v1/RetrieveTransactionPayment';
    static string $DETAILS_ORDER_URI = '/v1/RetrieveOrderPayment';
}