<?php

namespace Ocelot\Core\Foundation;

trait Mappable
{
    protected static $definition;

    /**
     * Get column definition
     *
     * @return array
     */
    public static function getDefinition()
    {
        return static::$definition;
    }
}
