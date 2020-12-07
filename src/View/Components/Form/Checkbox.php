<?php

namespace Ocelot\Core\View\Components\Form;

use Ocelot\Core\Foundation\View\Components\Form\AbstractInput;

class Checkbox extends AbstractInput
{
    /**
     * @var array|null Checkbox options
     */
    public $options;

    /**
     * @var bool Required input
     */
    public $required;

    /**
     * @var bool Disabled input
     */
    public $disabled;

    /**
     * @var bool All options show inline
     */
    public $inline;

    /**
     * @var bool|null Show the options as buttons
     */
    public $as_buttons;

    /**
     * @var bool Show the options as switches
     */
    public $as_switches;

    /**
     * @var string Input type
     */
    public $type = 'checkbox';

    /**
     * @inheritdoc
     */
    protected $view = 'core::components.form.checkbox';

    /**
     * Checkbox constructor.
     *
     * @param string $name
     * @param string|null $label
     * @param string|null $id
     * @param string|null $help
     * @param bool|null $noerror
     * @param string|null $size Button size, when showing as buttons
     * @param mixed|null $default
     * @param array|null $options
     * @param bool|null $required
     * @param bool|null $disabled
     * @param bool|null $inline
     * @param bool|null $asButtons
     * @param bool|null $asSwitches
     */
    public function __construct(
        string $name
        , string $label = null
        , string $id = null
        , string $help = null
        , bool $noerror = null
        , string $size = null
        , $default = null
        , array $options = null
        , bool $required = null
        , bool $disabled = null
        , bool $inline = null
        , bool $asButtons = null
        , bool $asSwitches = null
    )
    {
        parent::__construct(
            $name
            , $label
            , $id
            , $help
            , null
            , $noerror
            , $size
            , null
            , $default
        );

        $this->options = $options;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->inline = $inline;
        $this->as_buttons = $asButtons;
        $this->as_switches = $asSwitches;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        // Make sure the control always renders, even if no options were supplied
        if ( ! is_array($this->options)) {
            $this->options = [];
        }

        // Prepare the options array
        $src_options = $this->options;
        $this->options = [];
        $this->prepOptions($src_options);

        return parent::render();
    }

    /**
     * Prepare options array
     *
     * @param array $src_options
     */
    private function prepOptions(array $src_options)
    {
        foreach ($src_options as $key => $val) {
            $option = [
                'value' => $key,
                'label' => $val,
                'id' => uniqid('cb-'),
                'checked' => $this->isValueChecked($key),
            ];

            $this->options[] = $option;
        }
    }

    /**
     * Should the specified value be checked?
     *
     * @param string $value
     * @return bool
     */
    private function isValueChecked($value)
    {
        // Note: We use weak comparisons by purpose
        if ($this->current !== null) {
            if (is_array($this->current)) {
                return in_array($value, $this->current);
            } else {
                return $this->current == $value;
            }
        }

        return false;
    }

    /**
     * Get form-group classes
     *
     * @return string
     */
    public function getClasses()
    {
        $classes = [
            'form-group',
        ];

        if ($this->hasError()) {
            $classes[] = 'is-invalid';
        }

        return $this->attributes->merge(['class' => implode(' ', $classes)]);
    }

    /**
     * Get input name attribute
     *
     * @return string
     */
    public function getName()
    {
        return $this->name .'[]';
    }
}
