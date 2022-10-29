<?php

namespace SDLX\Core\View\Components\Form;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use SDLX\Core\Foundation\View\Components\Form\AbstractInput;

class Select extends AbstractInput
{
    /**
     * @var array Array of options
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
     * @inheritdoc
     */
    protected string $view = 'core::components.form.select';

    /**
     * Select constructor.
     *
     * @param string $name
     * @param string|null $label
     * @param string|null $id
     * @param string|null $help
     * @param string|null $placeholder
     * @param bool|null $no_error
     * @param string|null $size
     * @param object|null $object
     * @param mixed|null $default
     * @param bool|null $required
     * @param array|null $options
     * @param bool|null $multiple
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
    )
    {
        parent::__construct(
            $name,
            $label,
            $id,
            $help,
            $placeholder ?? ($multiple ? null : _('-- select value --')),
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
                } elseif ((string)$this->default === (string)$key) {
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
}
