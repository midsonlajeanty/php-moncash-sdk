<?php

declare(strict_types=1);

namespace Mds\Moncash;

use Mds\Moncash\Core\Constants;

class PaymentResponse
{
    /**
     * orderId - Order Id provided by your app.
     */
    private string $orderId;

    /**
     * amount - Amount to be paid.
     */
    private float $amount;

    /**
     * token - Token provided by Moncash.
     */
    private string $token;

    /**
     * expireAt - Expiration Date of the Token.
     */
    private \DateTime $expireAt;

    /**
     * gateway - Gateway Url.
     */
    private string $gateway;

    /**
     * @param  string  $orderId  Order Id provided by your app
     * @param  float  $amount  Amount to be paid
     * @param  string  $token  Token provided by Moncash
     * @param  \DateTime  $expireAt  Expiration Date of the Token
     * @param  string  $gateway  Gateway Url
     */
    public function __construct(
        string $orderId,
        float $amount,
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
     * @return string Order Id provided by your app
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * getAmount - Get Amount
     *
     * @return float Amount to be paid
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * getToken - Get Payment Token
     *
     * @return string Token provided by Moncash
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * getExpiresAt - Get Expiration Date of the Token
     *
     * @return \DateTime Expiration Date of the Token
     */
    public function getExpiresAt(): \DateTime
    {
        return $this->expireAt;
    }

    /**
     * getExpireAt - Deprecated, use getExpiresAt() instead
     *
     * @return \DateTime Expiration Date of the Token
     *
     * @deprecated Use getExpiresAt() instead.
     */
    public function getExpireAt(): \DateTime
    {
        @trigger_error('getExpireAt() is deprecated, use getExpiresAt() instead.', E_USER_DEPRECATED);

        return $this->getExpiresAt();
    }

    /**
     * getRedirect - Get Redirect Url
     *
     * @return string Redirect Url to Moncash Payment Gateway
     */
    public function getRedirect(): string
    {
        return $this->gateway . Constants::REDIRECT_URI . $this->getToken();
    }
}

\class_alias(PaymentResponse::class, \Mds\Moncash\Payment::class);
