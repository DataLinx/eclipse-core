<?php

namespace Eclipse\Core\View\Components\Form;

use Eclipse\Core\Foundation\View\Components\Form\AbstractInput;

class Switcher extends AbstractInput
{
    /**
     * @var string Input value
     */
    public mixed $value;

    /**
     * @var bool|null Disabled input
     */
    public ?bool $disabled;

    /**
     * @var bool|null All options show inline
     */
    public ?bool $inline;

    /**
     * @inheritdoc
     */
    protected string $view = 'core::components.form.switcher';

    /**
     * Checkbox constructor.
     *
     * @param string $name
     * @param mixed $value
     * @param string|null $label
     * @param string|null $id
     * @param string|null $help
     * @param bool|null $no_error
     * @param bool|null $default
     * @param bool|null $required
     * @param bool|null $disabled
     * @param bool|null $inline
     */
    public function __construct(
        string $name,
        mixed $value = '1',
        ?string $label = null,
        ?string $id = null,
        ?string $help = null,
        ?bool $no_error = null,
        ?bool $default = null,
        ?bool $required = null,
        ?bool $disabled = null,
        ?bool $inline = null,
    )
    {
        parent::__construct(
            $name,
            $label,
            $id,
            $help,
            null,
            $no_error,
            null,
            null,
            (bool)$default,
            $required,
        );

        $this->value = $value;
        $this->disabled = (bool)$disabled;
        $this->inline = (bool)$inline;
    }

    /**
     * @inheritDoc
     */
    public function getControlClasses(): string
    {
        $classes = [
            'form-check-input',
        ];

        if ($this->hasError()) {
            $classes[] = 'is-invalid';
        }

        return implode(' ', $classes);
    }

    /**
     * Is the switch checked?
     *
     * @return bool
     * @noinspection PhpUnused
     */
    public function isChecked(): bool
    {
        return (bool)$this->current;
    }

}
