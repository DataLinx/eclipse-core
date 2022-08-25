<?php

namespace SDLX\Core\Foundation\Testing;

use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Request;
use Mockery;

/**
 * Trait TestsComponents
 *
 * @package SDLX\Core\Testing
 */
trait TestsComponents
{
    /**
     * Mock data submitted to a form which is received by the old() helper.
     *
     * @param array $data Associative array of simulated form data
     */
    protected function mockSessionFlashedData($data)
    {
        $session = Mockery::mock(Session::class);
        $session->shouldReceive('getOldInput')->with(null, null)->andReturn($data);

        foreach ($data as $key => $val) {
            $session->shouldReceive('getOldInput')->with($key, null)->andReturn($val);
        }

        Request::setLaravelSession($session);
    }
}
