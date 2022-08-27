<?php

namespace SDLX\Core\Foundation\Database;

abstract class AbstractConfig extends Model
{
    use Mappable;

    /**
     * Get config instance for the specified site
     *
     * @param int $site_id Site ID
     * @return self
     */
    public static function fetch($site_id)
    {
        return self::where('site_id', $site_id)->first();
    }
}
