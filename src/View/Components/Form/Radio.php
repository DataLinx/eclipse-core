<?php

namespace Ocelot\Core\View\Components\Form;

/**
 * Form radio component - extends the checkbox component for a simple output tweak.
 *
 * @package Ocelot\Core\View\Components\Form
 */
class Radio extends Checkbox
{
    /**
     * @inheritdoc
     */
    public $type = 'radio';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->name;
    }
}
