<?php

use Ocelot\Core\Framework\Output\Toast;

if ( ! function_exists('app_base_path'))
{
    /**
     * Get the full Ocelot app installation base path
     *
     * @param string|null $path Optional relative path to a file/directory which will be appended
     * @return string
     * @throws Exception
     */
    function app_base_path($path = NULL)
    {
        if (app()->environment('testing'))
        {
            // When testing, APP_BASE_PATH must be set
            if (empty(env('APP_BASE_PATH')))
            {
                throw new Exception('APP_BASE_PATH must be set in .env for testing!');
            }

            return env('APP_BASE_PATH') . ($path ? ltrim($path, '/') : '');
        }

        // Otherwise, fallback to standard base_path()
        return base_path($path);
    }
}

if ( ! function_exists('package_path'))
{
    /**
     * Get full path to a package
     *
     * @param string $package Package name (e.g. ocelot/core)
     * @param string|null $path Optional relative path to a file/directory which will be appended
     * @return string
     * @throws Exception
     */
    function package_path($package, $path = NULL)
    {
        return app_base_path("vendor/$package") . ($path ? '/'. trim($path, '/') : '');
    }
}

/**
 * Create a toast
 *
 * @param string $message Toast message
 * @param string|null $title Optional title
 * @return Toast
 */
function toast(string $message, string $title = null)
{
    return app(\Ocelot\Core\Framework\Output::class)->toast($message, $title);
}
