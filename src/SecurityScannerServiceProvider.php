<?php
namespace YourNamespace;

use Illuminate\Support\ServiceProvider;

class SecurityScannerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SecurityScanner::class, function ($app) {
            return new SecurityScanner();
        });
    }

    public function boot()
    {
        // Publish any configuration files or assets if needed
    }
}
