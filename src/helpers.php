<?php

use Eclipse\Core\Framework\Output;
use Eclipse\Core\Framework\Output\Toast;

/**
 * Create a toast
 *
 * @param string $message Toast message
 * @param string|null $title Optional title
 * @return Toast
 */
function toast(string $message, string $title = null)
{
    return app(Output::class)->toast($message, $title);
}
