<?php

namespace Ocelot\Core\View\Components\Form;

use Illuminate\View\Component;

class Plaintext extends Component
{
    /**
     * @var string Label
     */
    public $label;

    /**
     * @var string HTML ID
     */
    public $id;

    /**
     * Plaintext constructor.
     *
     * @param string|null $label Label
     * @param string|null $id HTML ID - if not passed, then it's auto-generated
     */
    public function __construct(
        string $label = null
        , string $id = null
    )
    {
        $this->label = $label;
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        if (empty($this->id)) {
            $this->id = uniqid('plaintext-');
        }

        return view('core::components.form.plaintext');
    }
}
