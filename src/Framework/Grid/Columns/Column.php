<?php

namespace Eclipse\Core\Framework\Grid\Columns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Grid Column implementation
 */
class Column
{
    /**
     * @var string Column accessor (key)
     */
    protected string $accessor;

    /**
     * @var string Label
     */
    protected string $label;

    /**
     * @var int|null Column width in px
     */
    protected ?int $width;

    /**
     * @var bool Can the data be sorted by this column?
     */
    protected bool $sortable = true;

    /**
     * Create column object
     *
     * @param  string  $accessor Column accessor (key)
     * @param  string  $label Column label
     */
    public function __construct(string $accessor, string $label)
    {
        $this->accessor = $accessor;
        $this->label = $label;
    }

    public function getAccessor(): string
    {
        return $this->accessor;
    }

    /**
     * Get column label
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Render (print) the column
     */
    public function render(Model $object): string
    {
        $val = $object->getAttributeValue($this->accessor);

        if ($val === null) {
            $method = Str::camel('get_'.$this->accessor);

            if (method_exists($object, $method)) {
                $val = $object->$method();
            }
        }

        return $val ?? '';
    }

    public function getWidth(): ?int
    {
        return $this->width ?? null;
    }

    public function setWidth(int $width): Column
    {
        $this->width = $width;

        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @return $this
     */
    public function setSortable(bool $sortable): self
    {
        $this->sortable = $sortable;

        return $this;
    }
}
