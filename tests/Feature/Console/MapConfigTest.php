<?php

namespace Ocelot\Core\Tests\Feature\Console;

use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\Tests\TestObjects\Configs\InvalidConfigDefinition;

class MapConfigTest extends PackageTestCase
{
    public function testHandle()
    {
        // Trigger autoload
        $invalid_cfg = new InvalidConfigDefinition;

        $this->artisan('ocelot:map-config')
             ->expectsOutput(sprintf("Exception thrown when mapping columns for %s: %s", InvalidConfigDefinition::class, 'Column definition property not set'))
             ->assertExitCode(0);
    }
}