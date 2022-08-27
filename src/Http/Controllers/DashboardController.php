<?php

namespace SDLX\Core\Http\Controllers;

use SDLX\Core\Foundation\Http\Controllers\AbstractController;

class DashboardController extends AbstractController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('core::dashboard');
    }
}
