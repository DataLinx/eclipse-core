<?php

namespace Ocelot\Core\View\Components\Form;

use Ocelot\Core\Foundation\View\Components\Form\AbstractInput;

class File extends AbstractInput
{
    protected $view = 'core::components.form.file';

    /**
     * Get input element classes
     *
     * @return \Illuminate\View\ComponentAttributeBag|string
     */
    public function getClasses()
    {
        $classes = [
            'custom-file-input',
        ];

        if ($this->hasError()) {
            $classes[] = 'is-invalid';
        }

        return $this->attributes->merge(['class' => implode(' ', $classes)]);
    }
}
