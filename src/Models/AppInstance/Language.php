<?php

namespace SDLX\Core\Models\AppInstance;

use SDLX\Core\Database\Model;

/**
 * Class Language
 * @package SDLX\Core\Models\AppInstance
 *
 * @property int $id App instance language ID
 * @property int $app_instance_id App instance ID
 * @property string $language_id Language ID (alpha-2)
 * @property int $is_default Is default 0/1
 * @property int $sort_num Sorting number
 * @property int $fallback_sort_num Fallback sorting number
 */
class Language extends Model
{
    protected $table = 'core_app_instance_language';
}
