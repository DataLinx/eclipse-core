<?php

namespace Eclipse\Core\Framework\Output;

/**
 * Class Toast
 *
 * @package Eclipse\Core\Framework\Output
 * @method self success()
 * @method self danger()
 * @method self warning()
 * @method self sticky()
 */
class Toast
{
    /**
     * @var string Toast message
     */
    protected string $message;

    /**
     * @var string|null Optional title - will default based on toast type
     */
    protected ?string $title;

    /**
     * @var string Type: info (default), success, danger, warning
     */
    protected string $type = 'info';

    /**
     * @var string|null Icon for the header
     */
    protected ?string $icon;

    /**
     * @var bool Make toast sticky, which means it does not autohide and there's no way to close it
     */
    protected bool $sticky = false;

    /**
     * @var array|null An array of labels and links
     */
    protected ?array $links;

    /**
     * Toast constructor.
     *
     * @param string $message Toast message
     * @param string|null $title Optional custom title
     */
    public function __construct(string $message, string $title = null)
    {
        $this->message = $message;
        $this->title = $title;
    }

    public function __call($name, $arguments): self
    {
        switch ($name) {
            case 'info':
            case 'success':
            case 'danger':
            case 'warning':
                $this->type = $name;
                break;
            case 'sticky':
                $this->sticky = true;
                break;
        }

        return $this;
    }

    /**
     * Get toast message
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set toast title
     *
     * @param string $title
     * @return $this
     */
    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get toast title
     *
     * @return string
     */
    public function getTitle(): string
    {
        if (isset($this->title)) {
            return $this->title;
        }

        switch ($this->getType()) {
            case 'success':
                return _('Success');
            case 'danger':
                return _('Error');
            case 'warning':
                return _('Warning');
        }

        // Default title
        return _('Notice');
    }

    /**
     * Get toast type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type ?? 'info';
    }

    /**
     * Set icon
     *
     * @param string $name Icon name
     * @return $this
     */
    public function icon(string $name): self
    {
        $this->icon = $name;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        if (isset($this->icon)) {
            return $this->icon;
        }

        switch ($this->type) {
            case 'success':
                return 'check';
            case 'danger':
                return 'exclamation-circle';
            case 'warning':
                return 'exclamation-triangle';
        }

        // Default icon
        return 'info-circle';
    }

    /**
     * Is the Toast sticky?
     *
     * @return bool
     */
    public function isSticky(): bool
    {
        return $this->sticky;
    }

    /**
     * Add link
     *
     * @param string $label Label
     * @param string $href Link location / href attribute
     * @return $this
     */
    public function link(string $label, string $href): self
    {
        $this->links[$label] = $href;

        return $this;
    }

    /**
     * Does the toast have links?
     *
     * @return bool
     */
    public function hasLinks(): bool
    {
        return isset($this->links) && is_array($this->links) && count($this->links) > 0;
    }

    /**
     * Get toast links
     *
     * @return array|null
     */
    public function getLinks(): ?array
    {
        return $this->links ?? null;
    }
}
