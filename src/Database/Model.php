<?php
namespace SDLX\Core\Database;

use Illuminate\Database\Eloquent\Builder;

/**
 * Object Model class
 * @package SDLX\Core\Database
 * @mixin Builder
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
}
