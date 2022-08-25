<?php

namespace SDLX\Core\Framework\Grid\Columns;

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
    protected $accessor;

    /**
     * @var string Label
     */
    protected $label;

    /**
     * Create column object
     *
     * @param string $accessor Column accessor (key)
     * @param string $label Column label
     */
    public function __construct($accessor, $label)
    {
        $this->accessor = $accessor;
        $this->label = $label;
    }

    /**
     * Get column label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Render (print) the column
     *
     * @param Model $object
     * @return string
     */
    public function render(Model $object)
    {
        $val = $object->getAttributeValue($this->accessor);

        if ($val === null) {
            $method = Str::camel('get_'. $this->accessor);

            if (method_exists($object, $method)) {
                $val = $object->$method();
            }
        }

        return $val;
    }
}
