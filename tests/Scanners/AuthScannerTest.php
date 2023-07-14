<?php

namespace Tests\Unit;

use Your\Package\Namespace\AuthScanner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class AuthScannerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test checking debug mode
     *
     * @return void
     */
    public function testDebugMode()
    {
        Config::set('app.debug', true);
        
        $authScanner = new AuthScanner();
        $authScanner->scanAuth();
        
        $this->assertDatabaseHas('vulnerabilities', [
            'type' => 'Authentication',
            'severity' => 'High',
            'description' => 'Debug mode is enabled in production environment.'
        ]);
    }

    /**
     * Test checking sensitive configurations
     *
     * @return void
     */
    public function testSensitiveConfigurations()
    {
        Config::set('app.key', 'your-insecure-key');
        Config::set('database.connections.mysql.password', 'your-insecure-password');
        
        $authScanner = new AuthScanner();
        $authScanner->scanAuth();
        
        $this->assertDatabaseHas('vulnerabilities', [
            'type' => 'Authentication',
            'severity' => 'High',
            'description' => 'Sensitive configuration value detected: app.key'
        ]);

        $this->assertDatabaseHas('vulnerabilities', [
            'type' => 'Authentication',
            'severity' => 'High',
            'description' => 'Sensitive configuration value detected: database.connections.mysql.password'
        ]);
    }
}
