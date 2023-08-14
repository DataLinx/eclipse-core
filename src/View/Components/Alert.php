<?php

namespace Eclipse\Core\View\Components;

use Illuminate\View\Component;

/**
 * Class Alert
 * @package Eclipse\Core\View\Components
 */
class Alert extends Component
{
    /**
     * @var string Alert type (primary, secondary, success...)
     * @link https://getbootstrap.com/docs/5.2/components/alerts/#examples
     */
    public $type;

    /**
     * @var string|null Alert heading (optional)
     */
    public $heading;

    /**
     * @var bool|null Should be dismissible or not (default: false)
     */
    public $dismissible;

    /**
     * Alert constructor.
     *
     * @param string $type Alert type
     * @param string|null $heading Optional heading
     * @param bool|null $dismissible Dismissible or not (default: false)
     */
    public function __construct(
        string $type = 'primary'
        , string $heading = null
        , bool $dismissible = null
    )
    {
        $this->type = $type;
        $this->heading = $heading;
        $this->dismissible = $dismissible;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return <<<'blade'
            <div class="alert alert-{{ $type }} @if ($dismissible) alert-dismissible fade show @endif" role="alert" {{ $attributes }}>
                @if ($dismissible)
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ _('Close') }}"></button>
                @endif
                @if ($heading)
                    <h4 class="alert-heading">{{ $heading }}</h4>
                @endif
                {{ $slot }}
            </div>
        blade;
    }
}
