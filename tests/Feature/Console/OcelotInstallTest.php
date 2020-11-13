<?php

namespace Ocelot\Core\Tests\Feature\Console;

use Ocelot\Core\Testing\PackageTestCase;

class OcelotInstallTest extends PackageTestCase
{
    protected $ocelot_install = false;

    public function testHandle()
    {
        $cmd = $this->artisan('ocelot:install');

        // Test site creation
        $cmd->expectsQuestion('Enter the project domain name', 'test.ocelot.dev')
            ->expectsQuestion('Enter the project name', 'Ocelot Test')
            ->expectsConfirmation('Is this site served over HTTPS?', 'no')
            ->expectsOutput('Created site test.ocelot.dev');

        // Test user creation
        $cmd->expectsQuestion('What is your name?', 'John')
            ->expectsQuestion('What is your surname?', 'Doe')
            // Invalid email
            ->expectsQuestion('What is your e-mail address?', 'john')
            ->expectsOutput('The email must be a valid email address.')
            // Valid email
            ->expectsQuestion('What is your e-mail address?', 'john@datalinx.si')
            // Invalid password
            ->expectsQuestion('Please provide a password:', '1')
            ->expectsQuestion('Repeat the password:', '2')
            ->expectsOutput('The password confirmation does not match.')
            // Valid password
            ->expectsQuestion('Please provide a password:', 'test123')
            ->expectsQuestion('Repeat the password:', 'test123')
            ->expectsOutput('Created user john@datalinx.si');

        // Done
        $cmd->assertExitCode(0);
    }
}
