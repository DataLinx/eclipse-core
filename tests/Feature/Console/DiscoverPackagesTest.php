<?php

namespace Ocelot\Core\Tests\Feature\Console;

use Ocelot\Core\Foundation\Testing\PackageTestCase;
use Ocelot\Core\Models\Package;

class DiscoverPackagesTest extends PackageTestCase
{
    public function tearDown(): void
    {
        // Clean up test files and directories
        $files = [
            app_base_path('vendor/datalinx/package-type-change-test') .'/composer.json',
        ];

        $dirs = [
            app_base_path('vendor/datalinx/non-composer-test'),
            app_base_path('vendor/datalinx/package-type-change-test'),
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        foreach ($dirs as $dir) {
            if (file_exists($dir)) {
                rmdir($dir);
            }
        }

        parent::tearDown();
    }

    public function test_command_can_run()
    {
        // Create a mock package directory without composer.json
        $dir = app_base_path('vendor/datalinx/non-composer-test');

        if (! file_exists($dir)) {
            mkdir($dir);
        }

        $this->artisan('ocelot:discover-packages')
             ->assertExitCode(0);
    }

    public function test_package_type_change_can_be_handled()
    {
        $dir = app_base_path('vendor/datalinx/package-type-change-test');

        if (! file_exists($dir)) {
            mkdir($dir);
        }

        $json = [
            'extra' => [
                'ocelot' => [
                    'type' => 'app',
                ],
            ],
        ];

        file_put_contents("$dir/composer.json", json_encode($json));

        $this->artisan('ocelot:discover-packages')
             ->assertExitCode(0);

        $package = Package::where([
            'vendor' => 'datalinx',
            'name' => 'package-type-change-test',
        ])->first();

        $this->assertIsObject($package);
        $this->assertEquals(Package::TYPE_APP, $package->type);

        // Change package type
        $json['extra']['ocelot']['type'] = 'module';

        file_put_contents("$dir/composer.json", json_encode($json));

        $this->artisan('ocelot:discover-packages')
             ->assertExitCode(0);

        $package->refresh();

        $this->assertEquals(Package::TYPE_MODULE, $package->type);
    }
}
