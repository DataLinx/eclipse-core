<?php

namespace Eclipse\Core\Foundation\Database;

use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

/**
 * Trait that makes it easy to add composite attributes to database models.
 */
trait HasCompositeAttributes
{
    protected static array $composite_attributes;

    /**
     * Define composite attributes array.
     * Returns an array, where the keys are the column aliases and the values are SQL select statements, e.g.:
     * <code>
     * [
     *  "full_name" => "CONCAT(user.name, ' ', user.surname)"
     * ]
     * </code>
     *
     * @return array
     */
    abstract protected static function defineCompositeAttributes(): array;

    /**
     * Add composite attributes to a global scope
     *
     * @return void
     * @noinspection PhpUnused
     */
    protected function initializeHasCompositeAttributes(): void
    {
        static::addGlobalScope('composite', function (QueryBuilder $builder) {
            $builder->select($this->table .'.*');

            foreach (static::getCompositeAttributes() as $name => $definition) {
                $builder->addSelect(DB::raw($definition . ' AS ' . $name));
            }
        });
    }

    /**
     * Get defined composite attributes
     *
     * @return array
     */
    public static function getCompositeAttributes(): array
    {
        if (empty(static::$composite_attributes)) {
            static::$composite_attributes = static::defineCompositeAttributes();
        }

        return static::$composite_attributes;
    }

    /**
     * Does this model have the specified composite attribute?
     *
     * @param string $attr Attribute name
     * @return bool
     */
    public static function hasCompositeAttribute(string $attr): bool
    {
        return array_key_exists($attr, self::getCompositeAttributes());
    }

    /**
     * Get the composite attribute definition (actual part of the SQL query)
     *
     * @param string $attr
     * @return string|null
     */
    public static function getCompositeDefinition(string $attr): ?string
    {
        return self::getCompositeAttributes()[$attr] ?? null;
    }
}
