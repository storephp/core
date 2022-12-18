<?php

namespace Bidaea\OutMart\Modules\Catalogs;

use Illuminate\Support\ServiceProvider;

class CatalogsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/catalogs.php', 'outmart.catalogs');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

            $this->publishes([
                __DIR__ . '/config/catalogs.php' => config_path('outmart/catalogs.php'),
            ], ['outmart-catalogs-config', 'outmart-catalogs']);
        }
    }
}
