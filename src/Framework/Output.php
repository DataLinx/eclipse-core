<?php

namespace SDLX\Core\Framework;

use SDLX\Core\Framework\Output\Toast;

/**
 * Response output utility class
 *
 * @package SDLX\Core\Framework
 */
class Output
{
    /**
     * Create a new toast notification
     *
     * @param string $message Toast message
     * @return Toast
     */
    public function toast($message)
    {
        $toast = new Toast($message);

        session()->push('__toasts', $toast);

        return $toast;
    }

    /**
     * Get toast to show, which also removes them from the display queue.
     *
     * @return Toast[]
     */
    public function getToasts()
    {
        return session()->pull('__toasts') ?? [];
    }
}
