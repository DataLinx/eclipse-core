<?php
namespace Ocelot\Core\Database;

use Illuminate\Database\Eloquent\Builder;

/**
 * Object Model class
 * @package Ocelot\Core\Database
 * @mixin Builder
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
}
