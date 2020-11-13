<?php

namespace Ocelot\Core\Testing;

use Illuminate\Support\Facades\Artisan;
use Ocelot\Core\Providers\AuthServiceProvider;
use Ocelot\Core\Providers\CoreServiceProvider;
use Ocelot\Core\Providers\EventServiceProvider;
use Orchestra\Testbench\TestCase;

/**
 * Class PackageTestCase
 *
 * This should be used when implementing Ocelot packages
 *
 * @package Ocelot\Core\Tests
 */
class PackageTestCase extends TestCase
{
    /**
     * @var bool Run the Ocelot install procedure in setUp()
     */
    protected $ocelot_install = true;

    protected function getPackageProviders($app)
    {
        return [
            AuthServiceProvider::class,
            CoreServiceProvider::class,
            EventServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        if ($this->ocelot_install) {
            Artisan::call('ocelot:install -n'); // -n = no interaction, use testing defaults
        }

        $this->withoutMix();
    }
}