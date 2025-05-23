<?php

namespace App\Services\SAP;

use App\Services\SAP\Contracts\SAPServiceInterface;
use Illuminate\Support\ServiceProvider;

class SAPServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SAPServiceInterface::class, function ($app) {
            return new SAPService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
