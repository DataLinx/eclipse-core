<?php

namespace Eclipse\Core\Configuration;

use Eclipse\Core\Foundation\Database\AbstractConfig;
use Eclipse\Core\Framework\Database\Mapper;

/**
 * Class Config
 *
 * @property int $id Config ID
 * @property int $site_id Site ID
 * @property string $owner_name Owner name
 * @property string $owner_email Owner email address
 * @property string $owner_email_title Owner email title (used in "From" header)
 */
class Config extends AbstractConfig
{
    protected $table = 'core_config';

    protected static $definition = [
        'site_id',
        'owner_name' => [
            'type' => Mapper::TYPE_STRING,
            'required' => true,
            'default' => 'My company',
        ],
        'owner_email' => [
            'type' => Mapper::TYPE_STRING,
            'required' => true,
            'default' => 'info@example.com',
        ],
        'owner_email_title' => [
            'type' => Mapper::TYPE_STRING,
            'required' => true,
            'default' => 'My company',
        ],
    ];
}
