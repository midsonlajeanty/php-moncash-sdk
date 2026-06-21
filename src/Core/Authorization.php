<?php

declare(strict_types=1);

namespace Mds\Moncash\Core;

/**
 * Authorization
 *
 * @final
 */
class Authorization
{
    /**
     * @var string Moncash Access Token
     */
    private string $accessToken;

    /**
     * @var string Moncash Token Type
     */
    private string $tokenType;

    public function __construct(object $data)
    {
        $this->accessToken = (string) $data->access_token;
        $this->tokenType = (string) $data->token_type;
    }

    public static function fromResponse(\Psr\Http\Message\ResponseInterface $res): Authorization
    {
        $data = json_decode((string) $res->getBody());

        return new self($data);
    }

    public function getAuthorizationHeader(): string
    {
        return $this->tokenType . ' ' . $this->accessToken;
    }
}
