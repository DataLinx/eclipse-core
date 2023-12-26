<?php

namespace Eclipse\Core\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Eclipse\Core\Foundation\Http\Controllers\AbstractController;
use Eclipse\Core\Http\Requests\Auth\LoginRequest;
use Eclipse\Core\Providers\RouteServiceProvider;

class AuthenticatedSessionController extends AbstractController
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('core::auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
