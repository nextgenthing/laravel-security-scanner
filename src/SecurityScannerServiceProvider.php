<?php
namespace Nextgenthing\LaravelSecurityScanner;

use Illuminate\Support\ServiceProvider;
use Nextgenthing\LaravelSecurityScanner\Console\Commands\SecurityScanCommand;

class SecurityScannerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SecurityScanner::class, function ($app) {
            return new SecurityScanner();
        });
    }

    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SecurityScanCommand::class,
            ]);
        }
    }
}
