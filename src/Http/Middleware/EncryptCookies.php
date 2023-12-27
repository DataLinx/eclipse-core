<?php

namespace Eclipse\Core\Http\Middleware;

use Eclipse\Core\Framework\L10n;
use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    protected $except = [
        L10n::COOKIE_NAME,
    ];
}
