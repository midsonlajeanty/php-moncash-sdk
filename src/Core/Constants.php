<?php

declare(strict_types=1);

namespace Mds\Moncash\Core;

/**
 * Constants
 * @final
 */
class Constants
{
    public const LIVE_URL = "https://moncashbutton.digicelgroup.com/Api";
    public const SANDBOX_URL = "https://sandbox.moncashbutton.digicelgroup.com/Api";

    public const LIVE_BASE_GATEWAY = 'https://moncashbutton.digicelgroup.com/Moncash-middleware';
    public const SANDBOX_BASE_GATEWAY = 'https://sandbox.moncashbutton.digicelgroup.com/Moncash-middleware';

    public const TOKEN_URI = '/oauth/token';
    public const REDIRECT_URI = '/Payment/Redirect?token=';

    public const PAYMENT_URI = '/v1/CreatePayment';
    public const TRANSFERT_URI = '/v1/Transfert';
    public const DETAILS_TRANSACTION_URI = '/v1/RetrieveTransactionPayment';
    public const DETAILS_ORDER_URI = '/v1/RetrieveOrderPayment';
}
