<?php

namespace SDLX\Core\Framework\Grid\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use SDLX\Core\Foundation\Grid\AbstractFilter;

class SearchFilter extends AbstractFilter
{
    private array $exact_conditions = [];
    private array $partial_conditions = [];

    public function __construct(string $name = null, string $label = null)
    {
        parent::__construct($name ?: 'search', $label ?: _('Search'));
    }

    /**
     * @inheritDoc
     */
    public function apply(Builder $query, $filter_value = null): void
    {
        if ($filter_value !== null && $filter_value !== '') {
            $query->where(function (Builder $query) use ($filter_value) {
                foreach ($this->exact_conditions as $attribute) {
                    $query->orWhere($attribute, '=', $filter_value);
                }

                foreach ($this->partial_conditions as $attribute) {
                    $query->orWhere($attribute, 'like', '%'. $filter_value .'%');
                }
            });
        }
    }

    /**
     * Add attribute for exact column value matching
     *
     * @param string|array $attribute Attribute name or an array of attribute names
     * @return $this
     */
    public function addExactCondition($attribute): self
    {
        if (is_array($attribute)) {
            $this->exact_conditions = array_merge($this->exact_conditions, $attribute);
        } else {
            $this->exact_conditions[] = $attribute;
        }

        return $this;
    }

    /**
     * Add attribute for partial column value matching
     *
     * @param string|array $attribute Attribute name or an array of attribute names
     * @return $this
     */
    public function addPartialCondition($attribute): self
    {
        if (is_array($attribute)) {
            $this->partial_conditions = array_merge($this->partial_conditions, $attribute);
        } else {
            $this->partial_conditions[] = $attribute;
        }

        return $this;
    }
}
