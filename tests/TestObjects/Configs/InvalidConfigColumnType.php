<?php

namespace SDLX\Core\Tests\TestObjects\Configs;

use SDLX\Core\Foundation\AbstractConfig;

class InvalidConfigColumnType extends AbstractConfig
{
    protected $table = 'core_invalid_config_column_type';

    protected static $definition = [
        'col' => [
            'type' => 'foo',
        ],
    ];
}
