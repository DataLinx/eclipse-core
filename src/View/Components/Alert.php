<?php

namespace Eclipse\Core\View\Components;

use Illuminate\View\Component;

/**
 * Class Alert
 */
class Alert extends Component
{
    /**
     * @var string Alert type (primary, secondary, success...)
     *
     * @link https://getbootstrap.com/docs/5.2/components/alerts/#examples
     */
    public string $type;

    /**
     * @var string|null Alert heading (optional)
     */
    public ?string $heading;

    /**
     * @var bool|null Should be dismissible or not (default: false)
     */
    public ?bool $dismissible;

    /**
     * @var string|null Heading icon
     */
    public ?string $icon;

    /**
     * Alert constructor.
     *
     * @param  string  $type  Alert type
     * @param  string|null  $heading  Optional heading
     * @param  bool|null  $dismissible  Dismissible or not (default: false)
     */
    public function __construct(
        string $type = 'info',
        ?string $heading = null,
        ?bool $dismissible = null,
        ?string $icon = null,
    ) {
        $this->type = $type;
        $this->heading = $heading;
        $this->dismissible = $dismissible;
        $this->icon = $icon;
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return view('core::components.alert');
    }

    /**
     * Get the default icon for the alert type
     */
    public function getDefaultIcon(): string
    {
        switch ($this->type) {
            case 'success':
                return 'check-circle';
            case 'danger':
                return 'circle-exclamation';
            case 'warning':
                return 'triangle-exclamation';
            case 'info':
            default:
                return 'circle-info';
        }
    }
}
