<?php

use Eclipse\Core\Models\Package;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('local');
});

afterEach(function () {
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

});

test('command can run', function () {
    // Create a mock package directory without composer.json
    $dir = base_path('vendor/datalinx/non-composer-test');

    if (! file_exists($dir)) {
        mkdir($dir);
    }

    $this->artisan('eclipse:discover-packages --test')
        ->assertExitCode(0);

    Storage::disk('local')->assertExists('test-imports.js');
});

test('package type change can be handled', function () {
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

    expect($package)->toBeObject();
    expect($package->type)->toEqual(Package::TYPE_APP);

    // Change package type
    $json['extra']['eclipse']['type'] = 'module';

    file_put_contents("$dir/composer.json", json_encode($json));

    $this->artisan('eclipse:discover-packages')
        ->assertExitCode(0);

    $package->refresh();

    expect($package->type)->toEqual(Package::TYPE_MODULE);
});
