<?php

namespace Mds\Moncashify\Core;

class Config{

    public static function set(bool $debug){
        $config = new \stdClass();

        if($debug){
            $config->endpoint = Constants::$SANDBOX_URL;
            $config->baseGateway = Constants::$SANDBOX_BASE_GATEWAY;
        }else{
            $config->endpoint = Constants::$LIVE_URL;
            $config->baseGateway = Constants::$LIVE_BASE_GATEWAY;
        }

        return $config;
    }
}