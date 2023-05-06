<?php

namespace Store\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Store\BasketinServiceProvider;
use Store\Tests\Core\TestBasketinServiceProvider;

class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh', ['--database' => 'testing']);

        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            TestBasketinServiceProvider::class,
            BasketinServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBbBTsmF');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
