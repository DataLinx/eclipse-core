<?php

namespace SDLX\Core\Framework\Grid\Columns;

use Illuminate\Database\Eloquent\Model;

class ImageColumn extends Column
{
    /**
     * @var int|null Image display width
     */
    protected ?int $img_width;

    /**
     * @var int Image display height
     */
    protected int $img_height;

    /**
     * @param string $accessor Column accessor (key)
     * @param string $label Colum label
     * @param int|null $width Image display width
     * @param int|null $height Image display height
     */
    public function __construct(string $accessor, string $label, ?int $width = null, ?int $height = null)
    {
        parent::__construct($accessor, $label);

        $this->img_width = $width;
        $this->img_height = $height;
    }

    /**
     * @inheritDoc
     */
    public function render(Model $object): string
    {
        $src = parent::render($object);

        $settings = [];

        if ($this->img_width)
        {
            $settings['w'] = $this->img_width;
        }

        if ($this->img_height)
        {
            $settings['h'] = $this->img_height;
        }

        if ($src) {
            return '<img src="img/'. $src . (count($settings) > 0 ? '?'. http_build_query($settings) : '') .'"/>';
        }

        return '';
    }
}
