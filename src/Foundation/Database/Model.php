<?php
namespace Eclipse\Core\Foundation\Database;

use Illuminate\Database\Eloquent\Builder;

/**
 * Object Model class
 * @package Eclipse\Core\Database
 * @mixin Builder
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
}
