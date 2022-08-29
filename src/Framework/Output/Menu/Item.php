<?php

namespace SDLX\Core\Framework\Output\Menu;

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
     * @var string|null Item key which when not provided, defaults to $href
     */
    private ?string $key;

    /**
     * @var bool Is the item disabled
     */
    private bool $disabled = false;

    /**
     * @param string $label
     * @param string|null $href
     * @param string|null $key
     */
    public function __construct(string $label, ?string $href = null, ?string $key = null)
    {
        $this->label = $label;
        $this->href = $href;
        $this->key = $key ?? $href;

        if (is_null($this->key)) {
            throw new InvalidArgumentException("You must provide the item href or key parameter for \"$label\"!");
        }
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->href;
    }

    /**
     * @param string|null $href
     * @return $this
     */
    public function setHref(?string $href): self
    {
        $this->href = $href;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     * @return $this
     */
    public function setKey(?string $key): self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    /**
     * @param bool $disabled
     * @return $this
     */
    public function setDisabled(bool $disabled): self
    {
        $this->disabled = $disabled;
        return $this;
    }

    /**
     * Is this item's href the one being currently viewed?
     *
     * @return bool
     */
    public function isCurrent(): bool
    {
        return $this->href === url()->current();
    }

}
