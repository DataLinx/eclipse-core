<?php

namespace SDLX\Core\Framework\Output\Menu;

class Section extends Item
{
    /**
     * @var Item[]|null
     */
    private ?array $items = null;

    /**
     * Add item or sub-section to section
     *
     * @param Item|Section $item
     * @return $this
     */
    public function addItem(Item|Section $item): self
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Does this section have items?
     *
     * @return bool
     */
    public function hasItems(): bool
    {
        return isset($this->items) && count($this->items) > 0;
    }

    /**
     * @return Item[]|null
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * Add a divider element
     *
     * @return $this
     */
    public function addDivider(): self
    {
        $this->items[] = '_divider_';

        return $this;
    }

}
