<?php

namespace OutMart\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use OutMart\OutMartServiceProvider;
use OutMart\Tests\Core\TestOutMartServiceProvider;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh', ['--database' => 'testing']);

        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            TestOutMartServiceProvider::class,
            OutMartServiceProvider::class,
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
