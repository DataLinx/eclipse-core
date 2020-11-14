<?php

namespace Ocelot\Core\Tests\TestObjects\Configs;

use Ocelot\Core\Foundation\AbstractConfig;

class InvalidConfigColumnType extends AbstractConfig
{
    protected $table = 'cr_invalid_config_column_type';

    protected static $definition = [
        'col' => [
            'type' => 'foo',
        ],
    ];
}
