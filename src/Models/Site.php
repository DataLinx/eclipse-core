<?php

namespace SDLX\Core\Models;

use SDLX\Core\Foundation\Database\Model;

/**
 * Class Site
 * @package SDLX\Core\Models
 *
 * @property int $id Site ID
 * @property string $domain Domain
 * @property string $name Name
 * @property int $is_active Is active 0/1
 * @property int $is_main Is main site 0/1
 * @property int $is_secure Is secure site 0/1
 */
class Site extends Model
{
    protected $table = 'core_site';

    protected $attributes = [
        'is_active' => 1,
        'is_main' => 0,
    ];
}
