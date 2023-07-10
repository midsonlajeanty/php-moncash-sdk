<?php

namespace Mds\Moncash;

use Mds\Moncash\Core\Constants;

class Payment
{

    /**
     * orderId - Order Id provided by your app.
     *
     * @var string 
     */
    private $orderId;

    /**
     * amount - Amount to Paid
     *
     * @var float|int
     */
    private $amount;

    /**
     * token - Token provided by Moncash
     *
     * @var string
     */
    private $token;

    /**
     * expireAt - Expiration Date of the Token
     *
     * @var \DateTime
     */
    private $expireAt;

    /**
     * gateway - Gateway Url
     *
     * @var string
     */
    private $gateway;

    /**
     * __construct - Create Payment Object
     * 
     * @param  string $orderId  Order Id provided by your app.
     * @param  float|int $amount Amount to Paid
     * @param  string $token Token provided by Moncash
     * @param  \DateTime $expireAt Expiration Date of the Token
     * @param  string $gateway Gateway Url
     *
     * @return void
     */
    public function __construct(
        string $orderId,
        float|int $amount,
        string $token,
        \DateTime $expireAt,
        string $gateway
    ) {
        $this->orderId = $orderId;
        $this->amount = $amount;
        $this->token = $token;
        $this->expireAt = $expireAt;
        $this->gateway = $gateway;
    }

    /**
     * getOrderId - Get Order Id
     *
     * @return string Order Id provided by your app.
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * getAmount - Get Amount
     *
     * @return float|int Amount to Paid
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * getToken - Get Payment Token
     *
     * @return string Token provided by Moncash
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * getExpireAt - Get Expiration Date of the Token
     *
     * @return \DateTime Expiration Date of the Token
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }

    /**
     * getRedirect - Get Redirect Url
     *
     * @return string Redirect Url to Moncash Payment Gateway
     */
    public function getRedirect()
    {
        return $this->gateway . Constants::REDIRECT_URI . $this->getToken();
    }
}
