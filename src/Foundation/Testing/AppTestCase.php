<?php

namespace Eclipse\Core\Foundation\Testing;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class AppTestCase
 *
 * This should be used when implementing App tests.
 */
abstract class AppTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate')->run();
    }
}
