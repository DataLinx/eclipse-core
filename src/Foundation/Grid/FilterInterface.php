<?php

namespace SDLX\Core\Foundation\Grid;

use Illuminate\Contracts\Database\Query\Builder;

interface FilterInterface
{
    /**
     * Get filter name that is used for the form input name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get name that is used for the component wire:model attribute
     *
     * @return string
     */
    public function getModelName(): string;

    /**
     * Get form element label
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Apply filter to query
     *
     * @param Builder $query
     * @param mixed $filter_value
     * @return void
     */
    public function apply(Builder $query, $filter_value = null): void;

}
