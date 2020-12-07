<?php

namespace Ocelot\Core\View\Components\Form;

use Ocelot\Core\Foundation\View\Components\Form\AbstractInput;

class Switcher extends AbstractInput
{
    /**
     * @var string Input value
     */
    public $value;

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
     * @inheritdoc
     */
    protected $view = 'core::components.form.switcher';

    /**
     * Checkbox constructor.
     *
     * @param string $name
     * @param string $value
     * @param string|null $label
     * @param string|null $id
     * @param string|null $help
     * @param bool|null $noerror
     * @param bool|null $default
     * @param bool|null $required
     * @param bool|null $disabled
     * @param bool|null $inline
     */
    public function __construct(
        string $name
        , string $value = '1'
        , string $label = null
        , string $id = null
        , string $help = null
        , bool $noerror = null
        , bool $default = null
        , bool $required = null
        , bool $disabled = null
        , bool $inline = null
    )
    {
        parent::__construct(
            $name
            , $label
            , $id
            , $help
            , null
            , $noerror
            , null
            , null
            , (bool)$default
        );

        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->inline = $inline;
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
     * Is the switch checked?
     *
     * @return bool
     */
    public function isChecked()
    {
        return (bool)$this->current;
    }
}
