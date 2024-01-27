<?php

namespace Eclipse\Core\Foundation\Module;

/**
 * The AbstractModule class represents a base class for other modules. Each module should implement it and set the required `$vendor_name` and `$package_name` attributes.
 *
 * This class provides helper methods that make it easier to work with Eclipse modules.
 */
abstract class AbstractModule
{
    /**
     * @var string Vendor name
     */
    public static string $vendor_name;

    /**
     * @var string Package name
     */
    public static string $package_name;

    /**
     * Generates the URL for a module asset from the given path that is relative to the module `assets` path.
     *
     * @param  string  $path The path to the asset, **without leading slash**
     * @param  bool|null  $secure Whether the URL should be secure (HTTPS) or not. Defaults to null.
     * @return string The generated asset URL.
     */
    public static function asset(string $path, ?bool $secure = null): string
    {
        return asset(sprintf('modules/%s/%s/assets/%s', static::$vendor_name, static::$package_name, $path), $secure);
    }
}
