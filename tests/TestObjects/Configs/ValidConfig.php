<?php

namespace Tests\TestObjects\Configs;

use Eclipse\Core\Foundation\Database\AbstractConfig;
use Eclipse\Core\Framework\Database\Mapper;

class ValidConfig extends AbstractConfig
{
    protected $table = 'core_test_config';

    protected static $definition = [
        'site_id',
        'test_simple_string',
        'test_bool' => [
            'type' => Mapper::TYPE_BOOL,
            'default' => false,
        ],
        'test_date' => [
            'type' => Mapper::TYPE_DATE,
        ],
        'test_datetime' => [
            'type' => Mapper::TYPE_DATETIME,
        ],
        'test_float' => [
            'type' => Mapper::TYPE_FLOAT,
            'length' => 10,
            'decimals' => 5,
            'unsigned' => true,
        ],
        'test_integer' => [
            'type' => Mapper::TYPE_INTEGER,
        ],
        'test_string' => [
            'type' => Mapper::TYPE_STRING,
        ],
        'test_text' => [
            'type' => Mapper::TYPE_TEXT,
        ],
        'test_array' => [
            'type' => Mapper::TYPE_ARRAY,
        ],
        'test_mstring' => [
            'type' => Mapper::TYPE_MSTRING,
        ],
        'test_mtext' => [
            'type' => Mapper::TYPE_MTEXT,
        ],
        'test_object' => [
            'type' => Mapper::TYPE_OBJECT,
        ],
    ];
}
