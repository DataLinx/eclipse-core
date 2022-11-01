<?php

namespace SDLX\Core\Foundation\Testing;

use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase;
use SDLX\Core\Providers\AuthServiceProvider;
use SDLX\Core\Providers\CoreServiceProvider;
use SDLX\Core\Providers\EventServiceProvider;
use SDLX\Core\Providers\RouteServiceProvider;
use SDLX\Core\View\Grids\Users as UsersGrid;

/**
 * Class PackageTestCase
 *
 * This should be used when implementing SDLX packages
 *
 * @package SDLX\Core\Tests
 */
abstract class PackageTestCase extends TestCase
{
    /**
     * @var bool Run the SDLX install procedure in setUp()
     */
    protected $sdlx_install = true;

    protected $loadEnvironmentVariables = true;

    protected function getPackageProviders($app)
    {
        // We need to manually include this class, since the AppServiceProvider is set in providers in config/app.php
        require_once app_path('Providers/AppServiceProvider.php');

        // Our additional providers
        return [
            AuthServiceProvider::class,
            CoreServiceProvider::class,
            EventServiceProvider::class,
            RouteServiceProvider::class,
            LivewireServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        // Always show errors when testing
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        parent::setUp();

        if ($this->sdlx_install) {
            Artisan::call('sdlx:install -n'); // -n = no interaction, use testing defaults
        }

        $this->withoutVite();

        Livewire::component('users-grid', UsersGrid::class);
    }

    /**
     * Get the path to the skeleton dir, which is needed to load the correct configs etc. instead of using the ones Testbench provides
     *
     * @return string
     */
    protected function getBasePath(): string
    {
        return env('APP_BASE_PATH');
    }
}
