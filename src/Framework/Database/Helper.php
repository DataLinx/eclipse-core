<?php

namespace SDLX\Core\Framework\Database;

class Helper
{
    /**
     * Escape the parameter value for use it the LIKE part of the query
     *
     * @param string $param Parameter value
     * @return string
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