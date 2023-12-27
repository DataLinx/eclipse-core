<?php

namespace Tests\TestObjects\Configs;

use Eclipse\Core\Foundation\Database\AbstractConfig;

class InvalidConfigColumnType extends AbstractConfig
{
    protected $table = 'core_invalid_config_column_type';

    protected static $definition = [
        'col' => [
            'type' => 'foo',
        ],
    ];
}
