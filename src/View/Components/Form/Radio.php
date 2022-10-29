<?php

namespace SDLX\Core\View\Components\Form;

/**
 * Form radio component - extends the checkbox component for a simple output tweak.
 *
 * @package SDLX\Core\View\Components\Form
 */
class Radio extends Checkbox
{
    /**
     * @inheritdoc
     */
    public string $type = 'radio';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }
}
