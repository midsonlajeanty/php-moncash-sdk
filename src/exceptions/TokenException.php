<?php

namespace Mds\Moncashify\Exception;

class TokenException extends MoncashException
{
    public function __construct($message, $code = 1001)
    {
        parent::__construct($message, $code);
    }
}
