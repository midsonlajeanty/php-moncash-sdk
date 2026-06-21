<?php

declare(strict_types=1);

namespace Mds\Moncash\Core;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Mds\Moncash\Config;
use Mds\Moncash\Exception\ApiException;

/**
 * Core
 */
abstract class Core
{
    use Validation;

    /**
     * config - Moncash Config Object
     */
    private \Mds\Moncash\Config $config;

    /**
     * authorization - Lazy-loaded Authorization (OAuth token)
     */
    private ?\Mds\Moncash\Core\Authorization $authorization = null;

    /**
     * _endpoint - Base API URL
     *
     * @var string
     */
    protected $_endpoint;

    /**
     * _baseGateway - Base Gateway URL
     *
     * @var string
     */
    protected $_baseGateway;

    /**
     * _client - Guzzle Client
     *
     * @var ClientInterface
     */
    protected $_client;

    /**
     * @param  Config  $config  Moncash Config Object
     * @param  bool  $debug  `true` for development (sandbox), `false` for production
     */
    public function __construct(Config $config, bool $debug = true)
    {
        $this->config = $config;
        $this->setConfig($debug);
        $this->_client = new Client();
    }

    /**
     * getClient - Get Guzzle Client
     *
     * @return ClientInterface Guzzle Client
     */
    final public function getClient(): ClientInterface
    {
        return $this->_client;
    }

    /**
     * setClient - Set Guzzle Client
     *
     * @param  ClientInterface  $client  Guzzle Client
     */
    final public function setClient(ClientInterface $client): void
    {
        $this->_client = $client;
    }

    /**
     * setConfig - Set endpoints for development or production
     */
    private function setConfig(bool $debug): void
    {
        if ($debug) {
            $this->_endpoint = Constants::SANDBOX_URL;
            $this->_baseGateway = Constants::SANDBOX_BASE_GATEWAY;
        } else {
            $this->_endpoint = Constants::LIVE_URL;
            $this->_baseGateway = Constants::LIVE_BASE_GATEWAY;
        }
    }

    /**
     * getAuthorization - Lazily fetch and cache the OAuth authorization
     *
     * @throws ApiException
     */
    private function getAuthorization(): Authorization
    {
        if ($this->authorization instanceof Authorization) {
            return $this->authorization;
        }

        try {
            $res = $this->_client->request('POST', $this->_endpoint . Constants::TOKEN_URI, [
                'auth' => [$this->config->getClientId(), $this->config->getClientSecret()],
                'query' => [
                    'grant_type' => 'client_credentials',
                    'scope' => 'read,write',
                ],
            ]);

            $this->authorization = Authorization::fromResponse($res);

            return $this->authorization;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new ApiException($e->getResponse()->getBody()->getContents(), $e->getCode(), $e);
        }
    }

    /**
     * _getHeaders - Build authenticated HTTP headers
     *
     * @return array<string, string>
     *
     * @throws ApiException
     */
    protected function _getHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $this->getAuthorization()->getAuthorizationHeader(),
        ];
    }
}
