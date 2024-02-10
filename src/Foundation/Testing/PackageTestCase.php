<?php

namespace Eclipse\Core\Foundation\Testing;

use Illuminate\Support\Facades\Artisan;
use Orchestra\Testbench\TestCase;

/**
 * Class PackageTestCase
 *
 * This should be used when implementing Eclipse packages
 */
abstract class PackageTestCase extends TestCase
{
    /**
     * @var bool Run the Eclipse install procedure in setUp()
     */
    protected $eclipse_install = true;

    /**
     * @var bool Enable package discovery from composer.json
     */
    protected $enablesPackageDiscoveries = true;

    protected function setUp(): void
    {
        // Always show errors when testing
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        parent::setUp();

        if ($this->eclipse_install) {
            Artisan::call('eclipse:install -n'); // -n = no interaction, use testing defaults
        }

        $this->withoutVite();
    }

    /**
     * Get the path to the skeleton dir, which is needed to load the correct configs etc. instead of using the ones Testbench provides
     */
    protected function getBasePath(): string
    {
        return env('APP_BASE_PATH');
    }

    /**
     * {@inheritDoc}
     */
    public function ignorePackageDiscoveriesFrom(): array
    {
        return [
            // A list of packages that should not be auto-discovered when running tests
            'laravel/telescope',
        ];
    }
}
