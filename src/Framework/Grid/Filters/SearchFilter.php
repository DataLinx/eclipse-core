<?php

namespace SDLX\Core\Framework\Grid\Filters;

use Illuminate\Contracts\Database\Query\Builder;
use SDLX\Core\Foundation\Database\HasCompositeAttributes;
use SDLX\Core\Foundation\Grid\AbstractFilter;

class SearchFilter extends AbstractFilter
{
    protected string $model;
    private array $exact_conditions = [];
    private array $partial_conditions = [];

    public function __construct(string $model, string $name = null, string $label = null)
    {
        parent::__construct($name ?: 'search', $label ?: _('Search'));

        $this->model = $model;
    }

    /**
     * @inheritDoc
     */
    public function apply(Builder $query, $filter_value = null): void
    {
        if ($filter_value !== null && $filter_value !== '') {
            $query->where(function (Builder $query) use ($filter_value) {

                /** @var HasCompositeAttributes $class */
                $class = $this->model;

                foreach ($this->exact_conditions as $attribute) {
                    if ($class::hasCompositeAttribute($attribute)) {
                        $query->orWhereRaw($class::getCompositeDefinition($attribute) . ' = ?', [$filter_value]);
                    } else {
                        $query->orWhere($attribute, '=', $filter_value);
                    }
                }

                $filter_value = self::escapeLikeParameter($filter_value);

                foreach ($this->partial_conditions as $attribute) {
                    if ($class::hasCompositeAttribute($attribute)) {
                        $query->orWhereRaw($class::getCompositeDefinition($attribute) . " LIKE ?", ["%$filter_value%"]);
                    } else {
                        $query->orWhere($attribute, 'like', "%$filter_value%");
                    }
                }
            });
        }
    }

    /**
     * Add attribute for exact column value matching
     *
     * @param array|string $attribute Attribute name or an array of attribute names
     * @return $this
     */
    public function addExactCondition(array|string $attribute): self
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
     * @param array|string $attribute Attribute name or an array of attribute names
     * @return $this
     */
    public function addPartialCondition(array|string $attribute): self
    {
        if (is_array($attribute)) {
            $this->partial_conditions = array_merge($this->partial_conditions, $attribute);
        } else {
            $this->partial_conditions[] = $attribute;
        }

        return $this;
    }

    /**
     * Escape the parameter value for use it the LIKE part of the query
     *
     * @param string $param Parameter value
     * @return string
     */
    protected static function escapeLikeParameter($param): string
    {
        return str_replace(
            ['\\', '%', '_'],
            ['\\\\', '\\%', '\\_'],
            $param,
        );
    }
}
