<?php

namespace Eclipse\Core\Http\Controllers;

use Eclipse\Core\Foundation\Http\Controllers\AbstractController;

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
