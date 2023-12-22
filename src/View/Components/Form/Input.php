<?php

namespace Eclipse\Core\View\Components\Form;

use Eclipse\Core\Foundation\View\Components\Form\AbstractInput;
use Illuminate\View\ComponentAttributeBag;

class Input extends AbstractInput
{
    /**
     * @var string Input type (default: text)
     */
    public string $type;

    /**
     * @var string|null Input prepended content
     */
    public ?string $prepend;

    /**
     * @var string|null Input appended content
     */
    public ?string $append;

    /**
     * @inheritdoc
     */
    protected string $view = 'core::components.form.input';

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $type
     * @param string|null $label
     * @param string|null $id
     * @param string|null $help
     * @param string|null $placeholder
     * @param bool|null $no_error
     * @param string|null $size
     * @param object|null $object
     * @param mixed|null $default
     * @param bool|null $required
     * @param string|null $prepend
     * @param string|null $append
     */
    public function __construct(
        string $name,
        string $type = 'text',
        ?string $label = null,
        ?string $id = null,
        ?string $help = null,
        ?string $placeholder = null,
        ?bool $no_error = null,
        ?string $size = null,
        ?object $object = null,
        mixed $default = null,
        ?bool $required = null,
        ?string $prepend = null,
        ?string $append = null,
    )
    {
        parent::__construct(
            $name,
            $label,
            $id,
            $help,
            $placeholder,
            $no_error,
            $size,
            $object,
            $default,
            $required,
        );

        if ($type === 'decimal') {
            $this->type = 'text';
        } else {
            $this->type = $type;
        }

        $this->prepend = $prepend;
        $this->append = $append;
    }

    /**
     * @inheritDoc
     */
    public function getControlAttributes(): ComponentAttributeBag
    {
        switch ($this->type) {
            case 'number':
                return parent::getControlAttributes()->merge($this->attributes->only(['step', 'min', 'max', 'lang'])->getAttributes());
            default:
                return parent::getControlAttributes();
        }
    }

}
