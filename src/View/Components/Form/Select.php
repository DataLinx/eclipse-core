<?php

namespace Eclipse\Core\View\Components\Form;

use Closure;
use Eclipse\Core\Foundation\View\Components\Form\AbstractInput;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class Select extends AbstractInput
{
    /**
     * @var array|null Array of options
     */
    public ?array $options;

    /**
     * @var array Array of groups with options, which is auto-processed from the options array
     */
    public array $groups;

    /**
     * @var bool|null Allow selecting of multiple values
     */
    public ?bool $multiple;

    /**
     * {@inheritdoc}
     */
    protected string $view = 'core::components.form.select';

    /**
     * Select constructor.
     */
    public function __construct(
        string $name,
        ?string $label = null,
        ?string $id = null,
        ?string $help = null,
        ?string $placeholder = null,
        ?bool $no_error = null,
        ?string $size = null,
        ?object $object = null,
        mixed $default = null,
        ?bool $required = null,
        ?array $options = null,
        ?bool $multiple = null,
    ) {
        /** @noinspection NestedTernaryOperatorInspection */
        parent::__construct(
            $name,
            $label,
            $id,
            $help,
            is_null($placeholder) ? ($multiple ? null : _('-- select value --')) : $placeholder,
            $no_error,
            $size,
            $object,
            $default,
            $required,
        );

        $this->options = $options;
        $this->multiple = $multiple;
    }

    /**
     * {@inheritDoc}
     */
    public function render(): View|Factory|Htmlable|string|Closure|Application
    {
        // Make sure the control always renders, even if no options were supplied
        if (! is_array($this->options)) {
            $this->options = [];
        }

        // Prepare the options array
        $src_options = $this->options;
        $this->options = [];
        $this->groups = [];
        $this->prepOptions($src_options);

        return parent::render();
    }

    private function prepOptions($src_options, $group = null): void
    {
        foreach ($src_options as $key => $val) {
            if (is_array($val)) {
                // Option group
                if (! array_key_exists($key, $this->groups)) {
                    $this->groups[$key] = [
                        'label' => $key,
                        'options' => [],
                    ];
                }
                $this->prepOptions($val, $key);
            } else {
                // Standard option
                $option = [
                    'value' => $key,
                    'label' => $val,
                    'selected' => false,
                ];

                if ($this->multiple) {
                    if (is_array($this->default) && in_array($key, $this->default)) {
                        $option['selected'] = true;
                    }
                } elseif ((string) $this->default === (string) $key) {
                    $option['selected'] = true;
                }

                if ($group) {
                    $this->groups[$group]['options'][] = $option;
                } else {
                    $this->options[] = $option;
                }
            }
        }
    }

    /**
     * Get control classes
     */
    public function getControlClasses(): string
    {
        $classes = [
            'form-select',
        ];

        if ($this->size) {
            $classes[] = 'form-select-'.$this->size;
        }

        if ($this->hasError()) {
            $classes[] = 'is-invalid';
        }

        return implode(' ', $classes);
    }
}
