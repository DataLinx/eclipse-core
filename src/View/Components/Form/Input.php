<?php

namespace Ocelot\Core\View\Components\Form;

use Ocelot\Core\Foundation\View\Components\Form\AbstractInput;

class Input extends AbstractInput
{
    /**
     * @var string Input type (default: text)
     */
    public $type;

    /**
     * @var string|null Input prepended content
     */
    public $prepend;

    /**
     * @var string|null Input appended content
     */
    public $append;

    /**
     * @inheritdoc
     */
    protected $view = 'core::components.form.input';

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $type
     * @param string|null $label
     * @param string|null $id
     * @param string|null $help
     * @param string|null $placeholder
     * @param bool|null $noerror
     * @param string|null $size
     * @param object|null $object
     * @param null $default
     * @param string|null $prepend
     * @param string|null $append
     */
    public function __construct(
        string $name
        , string $type = 'text'
        , string $label = null
        , string $id = null
        , string $help = null
        , string $placeholder = null
        , bool $noerror = null
        , string $size = null
        , object $object = null
        , $default = null
        , string $prepend = null
        , string $append = null
    )
    {
        parent::__construct(
            $name
            , $label
            , $id
            , $help
            , $placeholder
            , $noerror
            , $size
            , $object
            , $default
        );

        $this->type = $type;
        $this->prepend = $prepend;
        $this->append = $append;
    }
}
