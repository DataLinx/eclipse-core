<?php

namespace Eclipse\Core\Framework\Grid\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use Eclipse\Core\Foundation\Grid\AbstractFilter;

class BooleanFilter extends AbstractFilter
{
    /**
     * @inheritDoc
     */
    public function apply(Builder $query, $filter_value = null): void
    {
        if ($filter_value) {
            $query->whereNotNull($this->name);
        }
    }
}
