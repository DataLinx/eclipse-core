<?php

namespace Eclipse\Core\View\Components\Form;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Eclipse\Core\Foundation\View\Components\Form\AbstractInput;

class Checkbox extends AbstractInput
{
    /**
     * @var array|null Checkbox options
     */
    public ?array $options;

    /**
     * @var bool|null Disabled input
     */
    public ?bool $disabled;

    /**
     * @var bool|null All options show inline
     */
    public ?bool $inline;

    /**
     * @var bool|null Show the options as buttons
     */
    public ?bool $as_buttons;

    /**
     * @var bool|null Show the options as switches
     */
    public ?bool $as_switches;

    /**
     * @var string Input type
     */
    public string $type = 'checkbox';

    /**
     * @inheritdoc
     */
    protected string $view = 'core::components.form.checkbox';

    /**
     * Checkbox constructor.
     *
     * @param string $name
     * @param string|null $label
     * @param string|null $id
     * @param string|null $help
     * @param bool|null $no_error
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
        string $name,
        string $label = null,
        string $id = null,
        string $help = null,
        bool $no_error = null,
        string $size = null,
        $default = null,
        bool $required = null,
        array $options = null,
        bool $disabled = null,
        bool $inline = null,
        bool $asButtons = null,
        bool $asSwitches = null,
    )
    {
        parent::__construct(
            $name,
            $label,
            $id,
            $help,
            null,
            $no_error,
            $size,
            null,
            $default,
            $required,
        );

        $this->options = $options;
        $this->disabled = $disabled;
        $this->inline = $inline;
        $this->as_buttons = $asButtons;
        $this->as_switches = $asSwitches;
    }

    /**
     * @inheritDoc
     */
    public function render(): View|Factory|Htmlable|string|Closure|Application
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
     * @return void
     */
    private function prepOptions(array $src_options): void
    {
        foreach ($src_options as $key => $val) {
            $option = [
                'value' => $key,
                'label' => $val,
                'id' => uniqid('cb-', true),
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
    private function isValueChecked(string $value): bool
    {
        // Note: We use weak comparisons by purpose
        if ($this->current !== null) {
            if (is_array($this->current)) {
                /** @noinspection TypeUnsafeArraySearchInspection */
                return in_array($value, $this->current);
            }

            /** @noinspection TypeUnsafeComparisonInspection */
            return $this->current == $value;
        }

        return false;
    }
    /**
     * Get form-group classes
     *
     * @return string
     */
    public function getControlClasses(): string
    {
        $classes = [];

        if ($this->as_buttons) {
            $classes[] = 'btn-check';
        } else {
            $classes[] = 'form-check-input';
            if ($this->hasError()) {
                $classes[] = 'is-invalid';
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Get input name attribute
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name .'[]';
    }
}
