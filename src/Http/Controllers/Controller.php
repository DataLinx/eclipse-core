<?php

namespace Ocelot\Core\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Ocelot\Core\Framework\Context;
use Ocelot\Core\Framework\L10n;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Context $context, L10n $l10n)
    {
        $context->initialize();

        $l10n->initialize()
             ->bindDomain('core', package_path('ocelot/core', 'resources/locales'), true);
    }
}
