<?php

namespace Mds\Moncashify\Exception;

class PaymentException extends MoncashException
{
    public function __construct($message, $code = 400)
    {
        parent::__construct($message, $code);
    }
}
