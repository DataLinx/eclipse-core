<?php

namespace Eclipse\Core\Framework\Database;

class Helper
{
    /**
     * Escape the parameter value for use it the LIKE part of the query
     *
     * @param  string  $param Parameter value
     */
    public static function escapeLikeParameter($param): string
    {
        return str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $param,
        );
    }
}
