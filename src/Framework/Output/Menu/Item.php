<?php

namespace Eclipse\Core\Framework\Output\Menu;

use InvalidArgumentException;

class Item
{
    /**
     * @var string Item label
     */
    private string $label;

    /**
     * @var string|null Href, if the item is a link
     */
    private ?string $href;

    /**
     * @var string|null Item key which when not provided, defaults to
     */
    private ?string $key;

    /**
     * @var bool Is the item disabled
     */
    private bool $disabled = false;

    public function __construct(string $label, ?string $href = null, ?string $key = null)
    {
        $this->label = $label;
        $this->href = $href;
        $this->key = $key ?? $href;

        if (is_null($this->key)) {
            throw new InvalidArgumentException("You must provide the item href or key parameter for \"$label\"!");
        }
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getHref(): ?string
    {
        return $this->href;
    }

    /**
     * @return $this
     */
    public function setHref(?string $href): self
    {
        $this->href = $href;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @return $this
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @return $this
     */
    public function setDisabled(bool $disabled): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Is this item's href the one being currently viewed?
     */
    public function isCurrent(): bool
    {
        return $this->href === url()->current();
    }
}
