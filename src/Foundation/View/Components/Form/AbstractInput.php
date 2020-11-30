<?php

namespace Ocelot\Core\Foundation\View\Components\Form;

use Illuminate\Validation\Validator;
use Illuminate\View\Component;

class AbstractInput extends Component
{
    /**
     * @var string Select name
     */
    public $name;

    /**
     * @var string|null Select label
     */
    public $label;

    /**
     * @var string|null Input ID - will be autogenerated if not supplied
     */
    public $id;

    /**
     * @var string|null Help text to display
     */
    public $help;

    /**
     * @var string|null Placeholder
     */
    public $placeholder;

    /**
     * @var bool|null Do not output the validation error message
     */
    public $noerror;

    /**
     * @var string|null Control/label size (lg or sm, defaults to standard)
     */
    public $size;

    /**
     * @var object|null Object from which to fetch the default, when not using the "default" attribute
     */
    public $object;

    /**
     * @var mixed|null Default input value
     */
    public $default;

    /**
     * @var string Blade view file
     */
    protected $view;

    /**
     * Select constructor.
     *
     * @param string $name
     * @param string|null $label
     * @param string|null $id
     * @param string|null $help
     * @param string|null $placeholder
     * @param bool|null $noerror
     * @param string|null $size
     * @param object|null $object
     * @param mixed|null $default
     */
    public function __construct(
        string $name
        , string $label = null
        , string $id = null
        , string $help = null
        , string $placeholder = null
        , bool $noerror = null
        , string $size = null
        , object $object = null
        , $default = null
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->id = $id;
        $this->help = $help;
        $this->placeholder = $placeholder;
        $this->noerror = $noerror;
        $this->size = $size;
        $this->object = $object;
        $this->default = $default;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        // Generate an id if it was not supplied, since we need it at least for the label
        if (empty($this->id)) {
            $this->id = 'i'. md5($this->name);
        }

        return view($this->view);
    }

    /**
     * Get form-control classes
     * @return string
     */
    public function getClasses()
    {
        $classes = [
            'form-control',
        ];

        if ($this->size) {
            $classes[] = 'input-size-'. $this->size;
        }

        if ($this->hasError()) {
            $classes[] = 'is-invalid';
        }

        return $this->attributes->merge(['class' => implode(' ', $classes)]);
    }

    protected function hasError()
    {
        /* @var $errors \Illuminate\Support\ViewErrorBag */
        $errors = view()->shared('errors');

        return $errors && $errors->has($this->name);
    }
}