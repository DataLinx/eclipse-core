<?php

namespace Eclipse\Core\View\Components;

use Illuminate\View\Component;

class Icon extends Component
{
    /**
     * @var string Icon name
     */
    public $name;

    /**
     * @var string Pack (fa, fas, far, fal, fab, fad - defaults to "fa")
     */
    public $pack;

    /**
     * @var string|null Icon color (as text-$color)
     * @link https://getbootstrap.com/docs/4.5/utilities/colors/
     */
    public $color;

    /**
     * Icon constructor.
     *
     * @param string $name Icon name
     * @param string $pack Pack
     * @param string|null $color Color
     */
    public function __construct(
        string $name
        , string $pack = 'fa'
        , string $color = null
    )
    {
        $this->name = $name;
        $this->pack = $pack;
        $this->color = $color;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return <<<'blade'
            <i {{ $getAttributes() }}></i>
        blade;
    }

    /**
     * Get icon element attributes
     *
     * @return string
     */
    public function getAttributes()
    {
        $classes = [
            $this->pack,
            'fa-'. $this->name,
        ];

        if ($this->color) {
            $classes[] = 'text-'. $this->color;
        }

        return $this->attributes->merge(['class' => implode(' ', $classes)]);
    }
}
