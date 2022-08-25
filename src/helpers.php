<?php

use SDLX\Core\Framework\Output\Toast;

/**
 * Create a toast
 *
 * @param string $message Toast message
 * @param string|null $title Optional title
 * @return Toast
 */
function toast(string $message, string $title = null)
{
    return app(\SDLX\Core\Framework\Output::class)->toast($message, $title);
}
