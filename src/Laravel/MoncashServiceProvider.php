<?php

declare(strict_types=1);

namespace Mds\Moncash\Laravel;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Mds\Moncash\Config;
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

            return new Moncash(
                new Config((string) ($config['client_id'] ?? ''), (string) ($config['client_secret'] ?? '')),
                (bool) ($config['debug'] ?? false)
            );
        });

        $this->app->alias(MoncashInterface::class, 'moncash');
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
