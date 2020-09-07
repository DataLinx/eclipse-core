<?php

namespace Ocelot\Core\Tests;

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

        $this->artisan('migrate')->run();
    }
}