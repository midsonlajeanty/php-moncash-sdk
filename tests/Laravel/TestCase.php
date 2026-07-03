<?php

declare(strict_types=1);

namespace Tests\Laravel;

use Illuminate\Foundation\Application;
use Mds\Moncash\Laravel\MoncashServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [MoncashServiceProvider::class];
    }

    /**
     * @param  Application  $app
     */
    protected function defineEnvironment($app): void
    {
        $app['config']->set('moncash', [
            'client_id' => 'test-client-id',
            'client_secret' => 'test-client-secret',
            'debug' => true,
        ]);
    }
}
