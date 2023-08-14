<?php

namespace Eclipse\Core\Http\Controllers\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Eclipse\Core\Foundation\Http\Controllers\AbstractController;
use Eclipse\Core\Http\Requests\Auth\LoginRequest;
use Eclipse\Core\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends AbstractController
{
    /**
     * Display the login view.
     *
     * @return View|Factory|Application
     */
    public function create(): View|Factory|Application
    {
        return view('core::auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \Eclipse\Core\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
