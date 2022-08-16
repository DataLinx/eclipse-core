<?php

namespace Ocelot\Core\Framework\Output;

/**
 * Class Toast
 *
 * @package Ocelot\Core\Framework\Output
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
    protected $message;

    /**
     * @var string|null Optional title - will default based on toast type
     */
    protected $title;

    /**
     * @var string Type: info (default), success, danger, warning
     */
    protected $type = 'info';

    /**
     * @var string Icon for the header
     */
    protected $icon;

    /**
     * @var bool Make toast sticky, which means it does not autohide and there's no way to close it
     */
    protected $sticky = false;

    /**
     * @var array An array of labels and links
     */
    protected $links;

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

    public function __call($name, $arguments)
    {
        switch ($name) {
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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set toast title
     *
     * @param string $title
     * @return $this
     */
    public function title(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get toast title
     *
     * @return string
     */
    public function getTitle()
    {
        if ($this->title) {
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
    public function getType()
    {
        return $this->type ?? 'info';
    }

    /**
     * Set icon
     *
     * @param string $name Icon name
     * @return $this
     */
    public function icon($name)
    {
        $this->icon = $name;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        if ($this->icon) {
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
    public function isSticky()
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
    public function link(string $label, string $href)
    {
        $this->links[$label] = $href;

        return $this;
    }

    /**
     * Does the toast have links?
     *
     * @return bool
     */
    public function hasLinks()
    {
        return is_array($this->links) && count($this->links) > 0;
    }

    /**
     * Get toast links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }
}