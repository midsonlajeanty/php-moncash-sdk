<?php

declare(strict_types=1);

namespace Mds\Moncash\Laravel;

use GuzzleHttp\Client;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Mds\Moncash\Config;
use Mds\Moncash\Core\Constants;
use Mds\Moncash\Exception\InvalidConfigException;
use Mds\Moncash\Moncash;
use Mds\Moncash\MoncashInterface;

final class MoncashServiceProvider extends ServiceProvider
{
    /**
     * Register the MonCash gateway in the container.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/moncash.php', 'moncash');

        $this->app->singleton(MoncashInterface::class, static function (Application $app): Moncash {
            /** @var Repository $repository */
            $repository = $app->make('config');

            /** @var array<string, mixed> $config */
            $config = $repository->get('moncash', []);

            $moncash = new Moncash(
                new Config(self::required($config, 'client_id'), self::required($config, 'client_secret')),
                (bool) ($config['debug'] ?? false)
            );

            $moncash->setClient(new Client([
                'timeout' => (float) ($config['timeout'] ?? Constants::DEFAULT_TIMEOUT),
                'connect_timeout' => (float) ($config['connect_timeout'] ?? Constants::DEFAULT_CONNECT_TIMEOUT),
            ]));

            return $moncash;
        });

        $this->app->alias(MoncashInterface::class, 'moncash');
    }

    /**
     * @param  array<string, mixed>  $config
     *
     * @throws InvalidConfigException
     */
    private static function required(array $config, string $key): string
    {
        $value = trim((string) ($config[$key] ?? ''));

        if ($value === '') {
            throw new InvalidConfigException(sprintf('Missing `moncash.%s` configuration (MONCASH_%s).', $key, strtoupper($key)));
        }

        return $value;
    }

    /**
     * Publish the configuration file when running in the console.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/moncash.php' => $this->app->basePath('config/moncash.php'),
            ], 'moncash-config');
        }
    }
}
