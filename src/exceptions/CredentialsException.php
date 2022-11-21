<?php

namespace Mds\Moncashify\Exception;

class CredentialsException extends MoncashException
{
    public function __construct($message, $code = 401)
    {
        parent::__construct($message, $code);
    }
}
