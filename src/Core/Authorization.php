<?php

namespace Mds\Moncashify\Core;

/**
 * Authorization
 * @final
 */
class Authorization{
    
    /**
     * accessToken - Access Token
     *
     * @var string Moncash Access Token
     */
    private $accessToken;
        
    /**
     * tokenType - Token Type
     *
     * @var string Moncash Token Type
     */
    private $tokenType;

        
    /**
     * __construct - Create a new Authorization instance
     *
     * @param  object $data Moncash Authorization Response
     * 
     * @return void
     */
    public function __construct(object $data){
        $this->accessToken = $data->access_token;
        $this->tokenType = $data->token_type;
    }
    
    /**
     * fromResponse - Create a new Authorization instance from Moncash Response
     *
     * @param  \Psr\Http\Message\ResponseInterface  $res Moncash Response
     * 
     * @return Authorization Moncash Authorization Object
     */
    public static function fromResponse(\Psr\Http\Message\ResponseInterface $res){
        $data = json_decode($res->getBody());
        return new self($data);
    }

    /**
     * getAuthorizationHeader - Get Authorization Header
     *
     * @return string Authorization Header
     */
    public function getAuthorizationHeader(){
        return $this->tokenType." ".$this->accessToken;
    }
}