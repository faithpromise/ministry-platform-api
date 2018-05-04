<?php

namespace App\Providers;

use MinistryPlatform\Http\Client;
use Illuminate\Support\ServiceProvider;

class MinistryPlatformServiceProvider extends ServiceProvider {
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton(Client::class, function ($app) {
            return new Client(
                config('ministryplatform.domain'),
                config('ministryplatform.client_id'),
                config('ministryplatform.client_secret'),
                config('ministryplatform.username'),
                config('ministryplatform.password')
            );
        });
    }
}
