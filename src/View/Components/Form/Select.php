<?php

namespace Ocelot\Core\View\Components\Form;

use Ocelot\Core\Foundation\View\Components\Form\AbstractInput;

class Select extends AbstractInput
{
    /**
     * @var array Array of options
     */
    public $options;

    /**
     * @var array Array of groups with options, which is auto-processed from the options array
     */
    public $groups;

    /**
     * @var bool Allow selecting of multiple values
     */
    public $multiple;

    /**
     * @inheritdoc
     */
    protected $view = 'core::components.form.select';

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
     * @param array|null $options
     * @param bool|null $multiple
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
        , array $options = null
        , bool $multiple = null
    )
    {
        parent::__construct(
            $name
            , $label
            , $id
            , $help
            , $placeholder ?? ($multiple ? null : _('-- select value --'))
            , $noerror
            , $size
            , $object
            , $default
        );

        $this->options = $options;
        $this->multiple = $multiple;
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
        $this->groups = [];
        $this->prepOptions($src_options);

        return parent::render();
    }

    private function prepOptions($src_options, $group = null)
    {
        foreach ($src_options as $key => $val) {
            if (is_array($val)) {
                // Option group
                if (! key_exists($key, $this->groups)) {
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
                } elseif ($this->default == $key) {
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
