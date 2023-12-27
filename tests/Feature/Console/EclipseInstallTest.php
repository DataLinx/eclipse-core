<?php

namespace Tests\Feature\Console;

use Eclipse\Core\Foundation\Testing\PackageTestCase;

class EclipseInstallTest extends PackageTestCase
{
    protected $eclipse_install = false;

    public function test_system_can_be_installed()
    {
        $cmd = $this->artisan('eclipse:install');

        // Test site creation
        $cmd->expectsQuestion('Enter the project domain name', 'eclipse.test')
            ->expectsQuestion('Enter the project name', 'Eclipse Test')
            ->expectsConfirmation('Is this site served over HTTPS?', 'no')
            ->expectsOutput('✓ Created site eclipse.test');

        // Test user creation
        $cmd->expectsQuestion('First name', 'John')
            ->expectsQuestion('Last name', 'Doe')
            // Invalid email
            ->expectsQuestion('E-mail address', 'john')
            ->expectsOutput('The email must be a valid email address.')
            // Valid email
            ->expectsQuestion('E-mail address', 'john@datalinx.si')
            // Invalid password
            ->expectsQuestion('Please provide a password', '1')
            ->expectsQuestion('Repeat the password', '2')
            ->expectsOutput('The password confirmation does not match.')
            // Valid password
            ->expectsQuestion('Please provide a password', 'test123')
            ->expectsQuestion('Repeat the password', 'test123')
            ->expectsOutput('✓ Created user john@datalinx.si');

        // Done
        $cmd->assertExitCode(0);
    }
}
