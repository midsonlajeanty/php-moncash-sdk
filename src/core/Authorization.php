<?php

namespace Mds\Moncashify\Core;

class Authorization{

    private $accessToken;
    private $tokenType;

    public function __construct(object $data){
        $this->accessToken = $data->access_token;
        $this->tokenType = $data->token_type;
    }

    public function getAuthorizationHeader(){
        return $this->tokenType." ".$this->accessToken;
    }
}