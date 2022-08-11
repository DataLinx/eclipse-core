<?php

namespace Ocelot\Core\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Ocelot\Core\Framework\L10n;

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
