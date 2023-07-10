<?php

namespace Mds\Moncash\Core;

/**
 * Constants
 * @final
 */
class Constants
{

    const LIVE_URL = "https://moncashbutton.digicelgroup.com/Api";
    const SANDBOX_URL = "https://sandbox.moncashbutton.digicelgroup.com/Api";

    const LIVE_BASE_GATEWAY = 'https://moncashbutton.digicelgroup.com/Moncash-middleware';
    const SANDBOX_BASE_GATEWAY = 'https://sandbox.moncashbutton.digicelgroup.com/Moncash-middleware';

    const TOKEN_URI = '/oauth/token';
    const REDIRECT_URI = '/Payment/Redirect?token=';

    const PAYMENT_URI = '/v1/CreatePayment';
    const TRANSFERT_URI = '/v1/Transfert';
    const DETAILS_TRANSACTION_URI = '/v1/RetrieveTransactionPayment';
    const DETAILS_ORDER_URI = '/v1/RetrieveOrderPayment';
}

