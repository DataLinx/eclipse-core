<?php

namespace Eclipse\Core\Framework\Grid\Filters;

use Eclipse\Core\Foundation\Grid\AbstractFilter;
use Illuminate\Contracts\Database\Query\Builder;

class BooleanFilter extends AbstractFilter
{
    /**
     * {@inheritDoc}
     */
    public function apply(Builder $query, $filter_value = null): void
    {
        if ($filter_value) {
            $query->whereNotNull($this->name);
        }
    }
}
