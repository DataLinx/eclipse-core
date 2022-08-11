<?php

namespace Ocelot\Core\Models;

use Ocelot\Core\Database\Model;

/**
 * Class AppInstance
 * @package Ocelot\Core\Models
 *
 * @property int $id App instance ID
 * @property int $site_id Site ID
 * @property int $app_package_id App package ID
 * @property string $path Relative path in URL to access the app instance
 * @property int $is_active Is active 0/1
 */
class AppInstance extends Model
{
    protected $table = 'core_app_instance';

    protected $attributes = [
        'is_active' => 1,
    ];
}
