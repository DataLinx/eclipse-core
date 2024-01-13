<?php

namespace Tests\Feature\Console;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Models\Package;
use Illuminate\Support\Facades\Storage;

class DiscoverPackagesTest extends PackageTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    public function tearDown(): void
    {
        // Clean up test files and directories
        $files = [
            base_path('vendor/datalinx/package-type-change-test/composer.json'),
        ];

        $dirs = [
            base_path('vendor/datalinx/non-composer-test'),
            base_path('vendor/datalinx/package-type-change-test'),
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
        $dir = base_path('vendor/datalinx/non-composer-test');

        if (! file_exists($dir)) {
            mkdir($dir);
        }

        $this->artisan('eclipse:discover-packages --test')
            ->assertExitCode(0);

        Storage::disk('local')->assertExists('test-imports.js');
    }

    public function test_package_type_change_can_be_handled()
    {
        $dir = base_path('vendor/datalinx/package-type-change-test');

        if (! file_exists($dir)) {
            mkdir($dir);
        }

        $json = [
            'extra' => [
                'eclipse' => [
                    'type' => 'app',
                ],
            ],
        ];

        file_put_contents("$dir/composer.json", json_encode($json));

        $this->artisan('eclipse:discover-packages')
            ->assertExitCode(0);

        $package = Package::where([
            'vendor' => 'datalinx',
            'name' => 'package-type-change-test',
        ])->first();

        $this->assertIsObject($package);
        $this->assertEquals(Package::TYPE_APP, $package->type);

        // Change package type
        $json['extra']['eclipse']['type'] = 'module';

        file_put_contents("$dir/composer.json", json_encode($json));

        $this->artisan('eclipse:discover-packages')
            ->assertExitCode(0);

        $package->refresh();

        $this->assertEquals(Package::TYPE_MODULE, $package->type);
    }
}
