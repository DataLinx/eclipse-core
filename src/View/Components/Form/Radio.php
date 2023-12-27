<?php

namespace Eclipse\Core\View\Components\Form;

/**
 * Form radio component - extends the checkbox component for a simple output tweak.
 */
class Radio extends Checkbox
{
    /**
     * {@inheritdoc}
     */
    public string $type = 'radio';

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }
}
