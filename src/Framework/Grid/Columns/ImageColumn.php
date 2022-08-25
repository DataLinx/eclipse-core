<?php

namespace SDLX\Core\Framework\Grid\Columns;

use Illuminate\Database\Eloquent\Model;

class ImageColumn extends Column
{
    /**
     * @var int Image display width
     */
    protected int $width;

    /**
     * @var int Image display height
     */
    protected int $height;

    /**
     * @param string $accessor Column accessor (key)
     * @param string $label Colum label
     * @param int|null $width Image display width
     * @param int|null $height Image display height
     */
    public function __construct($accessor, $label, int $width = null, int $height = null)
    {
        parent::__construct($accessor, $label);

        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @inheritDoc
     */
    public function render(Model $object)
    {
        $src = parent::render($object);

        $settings = [];

        if ($this->width)
        {
            $settings['w'] = $this->width;
        }

        if ($this->height)
        {
            $settings['h'] = $this->height;
        }

        if ($src) {
            return '<img src="img/'. $src . (count($settings) > 0 ? '?'. http_build_query($settings) : '') .'"/>';
        }

        return '';
    }
}
