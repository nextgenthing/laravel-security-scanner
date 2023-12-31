<?php
namespace Nextgenthing\LaravelSecurityScanner\Console\Commands;

use Illuminate\Console\Command;
use Nextgenthing\LaravelSecurityScanner\SecurityScanner;

class SecurityScanCommand extends Command
{
    protected $signature = 'security:scan';
    protected $description = 'Scan the Laravel application for security vulnerabilities';

    public function handle()
    {
        $scanner = app(SecurityScanner::class);
        
        // Perform various scans (routes, views, controllers, etc.)
        $scanner->scanRoutes();
        $scanner->scanViews();

        // Get the list of vulnerabilities
        $vulnerabilities = $scanner->getVulnerabilities();

        // Display or store the vulnerabilities
        $this->info('Found vulnerabilities:');
        foreach ($vulnerabilities as $vulnerability) {
            $this->line($vulnerability);
        }
    }
}
