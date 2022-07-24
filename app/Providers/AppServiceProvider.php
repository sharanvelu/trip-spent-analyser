<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force Https based on incoming protocol.
        if (request()->header('x-forwarded-proto') == 'https' || $this->app->isProduction()) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }
}
