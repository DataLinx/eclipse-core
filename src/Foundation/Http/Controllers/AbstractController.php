<?php

namespace Eclipse\Core\Foundation\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Eclipse\Core\Framework\Context;
use Eclipse\Core\Framework\L10n;

abstract class AbstractController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Context $context, L10n $l10n)
    {
        $context->initialize();

        $l10n->initialize()
            ->bindDomain('core', __DIR__ . '/../../../../resources/locales', true);
    }
}
