<?php

namespace Tests\Unit\Scanners;

use Your\Package\Namespace\ConfigScanner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ConfigScannerTest extends TestCase
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
        
        $configScanner = new ConfigScanner();
        $configScanner->scanConfiguration();
        
        $this->assertDatabaseHas('vulnerabilities', [
            'type' => 'Configuration',
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
        
        $configScanner = new ConfigScanner();
        $configScanner->scanConfiguration();
        
        $this->assertDatabaseHas('vulnerabilities', [
            'type' => 'Configuration',
            'severity' => 'High',
            'description' => 'Sensitive configuration value detected: app.key'
        ]);

        $this->assertDatabaseHas('vulnerabilities', [
            'type' => 'Configuration',
            'severity' => 'High',
            'description' => 'Sensitive configuration value detected: database.connections.mysql.password'
        ]);
    }
}
