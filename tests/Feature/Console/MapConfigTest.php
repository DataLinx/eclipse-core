<?php

namespace SDLX\Core\Tests\Feature\Console;

use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\Tests\TestObjects\Configs\InvalidConfigDefinition;

class MapConfigTest extends PackageTestCase
{
    public function test_invalid_config_can_be_detected()
    {
        // Trigger autoload
        $invalid_cfg = new InvalidConfigDefinition;

        $this->artisan('sdlx:map-config')
             ->expectsOutput(sprintf("Exception thrown when mapping columns for %s: %s", InvalidConfigDefinition::class, 'Column definition property not set'))
             ->assertExitCode(0);
    }
}
