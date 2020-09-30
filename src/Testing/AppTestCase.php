<?php

namespace Ocelot\Core\Testing;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class AppTestCase
 *
 * This should be used when implementing App tests.
 *
 * @package Ocelot\Core\Testing
 */
abstract class AppTestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate')->run();
    }
}
