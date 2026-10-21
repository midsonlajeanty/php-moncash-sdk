<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | MonCash credentials
    |--------------------------------------------------------------------------
    |
    | The client id and secret issued by Digicel for your MonCash business
    | account. Keep them out of version control by reading them from the
    | environment.
    |
    */

    'client_id' => env('MONCASH_CLIENT_ID', ''),

    'client_secret' => env('MONCASH_CLIENT_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | Sandbox mode
    |--------------------------------------------------------------------------
    |
    | When true, requests hit the MonCash sandbox gateway. It defaults to
    | false (live gateway); set MONCASH_DEBUG=true in local environments.
    |
    */

    'debug' => (bool) env('MONCASH_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | HTTP timeouts
    |--------------------------------------------------------------------------
    |
    | Seconds to wait for the MonCash gateway to accept the connection and to
    | answer a request. Without them an unreachable gateway blocks each call
    | for minutes.
    |
    */

    'timeout' => (float) env('MONCASH_TIMEOUT', 10),

    'connect_timeout' => (float) env('MONCASH_CONNECT_TIMEOUT', 10),
];
