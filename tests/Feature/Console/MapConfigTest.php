<?php

use Tests\TestObjects\Configs\InvalidConfigDefinition;

test('invalid config can be detected', function () {
    // Trigger autoload
    $invalid_cfg = new InvalidConfigDefinition;

    $this->artisan('eclipse:map-config')
        ->expectsOutput(sprintf('Exception thrown when mapping columns for %s: %s', InvalidConfigDefinition::class, 'Column definition property not set'))
        ->assertExitCode(0);
});
