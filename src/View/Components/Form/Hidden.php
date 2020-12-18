<?php

namespace Ocelot\Core\View\Components\Form;

use Illuminate\View\Component;

class Hidden extends Component
{
    /**
     * @var array Associative array with data keys and values
     */
    public $data;

    /**
     * Hidden constructor.
     * Either the name and value pair can be supplied or a data array with the same values.
     *
     * @param string|null $name Input name
     * @param mixed|null $value Input value
     * @param array|null $data Data array for multiple inputs
     */
    public function __construct(
        string $name = null
        , $value = null
        , array $data = null
    )
    {
        if (! is_null($name) && ! is_null($value)) {
            $this->data[$name] = $value;
        } elseif (is_array($data)) {
            $this->data = $data;
        }
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $str = '';

        if (! empty($this->data)) {
            foreach ($this->data as $name => $value) {
                $str .= $this->makeHtml($name, $value);
            }
        }

        return $str;
    }

    /**
     * Make the form input HTML
     *
     * @param string $name Input name
     * @param string|array $value Input value or array with key-value pairs
     * @return string
     */
    private function makeHtml($name, $value)
    {
        if (is_array($value)) {
            $html = '';
            foreach ($value as $key => $val) {
                $html .= $this->makeHtml($name . (is_int($key) ? '[]' : "[$key]"), $val);
            }
        } else {
            $html = '<input name="'. $name .'" type="hidden" value="'. e($value) .'" />';
        }

        return $html;
    }
}
