<?php

namespace Eclipse\Core\Foundation\Grid;

use Illuminate\Contracts\Database\Query\Builder;

interface FilterInterface
{
    /**
     * Get filter name that is used for the form input name
     */
    public function getName(): string;

    /**
     * Get name that is used for the component wire:model attribute
     */
    public function getModelName(): string;

    /**
     * Get form element label
     */
    public function getLabel(): string;

    /**
     * Apply filter to query
     *
     * @param  mixed  $filter_value
     */
    public function apply(Builder $query, $filter_value = null): void;
}
