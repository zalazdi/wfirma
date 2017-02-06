<?php

namespace Zalazdi\wFirma\Providers;

use Illuminate\Support\ServiceProvider;
use Zalazdi\wFirma\Client;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            return new Client($app['config']['wfirma']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Client::class];
    }

}
