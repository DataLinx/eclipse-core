<?php

namespace Ocelot\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class Test extends Controller
{
    public function components(): Renderable
    {
        return view('core::test.components');
    }
}
