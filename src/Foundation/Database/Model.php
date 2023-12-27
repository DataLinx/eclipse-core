<?php

namespace Eclipse\Core\Foundation\Database;

use Illuminate\Database\Eloquent\Builder;

/**
 * Object Model class
 *
 * @mixin Builder
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
}
