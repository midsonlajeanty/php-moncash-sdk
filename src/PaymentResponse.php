<?php

declare(strict_types=1);

namespace Mds\Moncash;

use Mds\Moncash\Core\Constants;

final readonly class PaymentResponse
{
    /**
     * @param  string  $orderId  Order Id provided by your app
     * @param  float  $amount  Amount to be paid
     * @param  string  $token  Token provided by Moncash
     * @param  \DateTime  $expireAt  Expiration Date of the Token
     * @param  string  $gateway  Gateway Url
     */
    public function __construct(private string $orderId, private float $amount, private string $token, private \DateTime $expireAt, private string $gateway) {}

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
     * getRedirect - Get Redirect Url
     *
     * @return string Redirect Url to Moncash Payment Gateway
     */
    public function getRedirect(): string
    {
        return $this->gateway.Constants::REDIRECT_URI.$this->getToken();
    }
}
