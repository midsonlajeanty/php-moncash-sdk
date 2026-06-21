<?php

declare(strict_types=1);

namespace Mds\Moncash;

use Mds\Moncash\Exception\InvalidConfigException;

/**
 * Payment Configuration
 *
 * @final
 */
class Config
{
    /**
     * clientId - Client Id
     *
     * @var string Client Id provided by Moncash
     */
    private string $clientId;

    /**
     * clientSecret - Client Secret
     *
     * @var string Client Secret provided by Moncash
     */
    private string $clientSecret;

    /**
     * @param  string  $clientId  Client Id provided by Moncash
     * @param  string  $clientSecret  Client Secret provided by Moncash
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * from - Create a new Config instance from Configuration Array
     *
     * @param  array<string, mixed>  $config  Moncash Configuration Array
     * @return Config Moncash Config Object
     *
     * @throws InvalidConfigException
     */
    public static function from(array $config): Config
    {
        if (! isset($config['clientId']) || empty($config['clientId'])) {
            throw new InvalidConfigException('Missing `clientId` in configuration array');
        }

        if (! isset($config['clientSecret']) || empty($config['clientSecret'])) {
            throw new InvalidConfigException('Missing `clientSecret` in configuration array');
        }

        return new self(
            (string) $config['clientId'],
            (string) $config['clientSecret']
        );
    }

    /**
     * fromArray - Deprecated, use from() instead
     *
     * @param  array<string, mixed>  $config  Moncash Configuration Array
     * @return Config Moncash Config Object
     *
     * @deprecated Use Config::from() instead.
     */
    public static function fromArray(array $config): Config
    {
        @trigger_error('Config::fromArray() is deprecated, use Config::from() instead.', E_USER_DEPRECATED);

        return self::from($config);
    }

    /**
     * getClientId - Get Client Id
     *
     * @return string Client Id provided by Moncash
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * getClientSecret - Get Client Secret
     *
     * @return string Client Secret provided by Moncash
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * toArray - Convert Config Object to Array
     *
     * @return array{clientId: string, clientSecret: string} Config as Array
     */
    public function toArray(): array
    {
        return [
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ];
    }
}
