<?php

namespace SDLX\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use SDLX\Core\Foundation\Http\Controllers\AbstractController;

class TestController extends AbstractController
{
    public function components(): Renderable
    {
        return view('core::test.components');
    }
}
