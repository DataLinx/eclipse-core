<?php

namespace SDLX\Core\Tests\Feature\Console;

use SDLX\Core\Foundation\Testing\PackageTestCase;

class SDLXInstallTest extends PackageTestCase
{
    protected $sdlx_install = false;

    public function test_system_can_be_installed()
    {
        $cmd = $this->artisan('sdlx:install');

        // Test site creation
        $cmd->expectsQuestion('Enter the project domain name', 'test.sdlx.dev')
            ->expectsQuestion('Enter the project name', 'SDLX Test')
            ->expectsConfirmation('Is this site served over HTTPS?', 'no')
            ->expectsOutput('Created site test.sdlx.dev');

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
