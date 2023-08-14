<?php

namespace Eclipse\Core\Framework\Output;

use Exception;
use InvalidArgumentException;
use Eclipse\Core\Framework\Output\Menu\Item;
use Eclipse\Core\Framework\Output\Menu\Section;

/**
 * The main application navigation menu
 */
class Menu
{
    /**
     * @var Item[]
     */
    private array $items = [];

    /**
     * @var string|null The "after" key, when inserting items after another specific item
     */
    private ?string $after;

    /**
     * Add item to the top level of the menu
     *
     * @param Item|Section $item Item or Section instance
     * @return $this
     * @throws Exception
     */
    public function addItem(Section|Item $item): self
    {
        if (isset($this->after)) {
            try {
                $items = arr($this->items);

                if ($items->positionOfKey($this->after) === null) {
                    throw new InvalidArgumentException(sprintf('Key "%s" not found', $this->after));
                }

                $items->afterKey($this->after)->insert($item, $item->getKey());
                $this->items = $items->toArray();

                // Clear the "after" key
                $this->after = null;
            } catch (Exception $exception) {
                throw new Exception(sprintf('Could not add item after key "%s": %s', $this->after, $exception->getMessage()), null, $exception);
            }
        } else {
            if (key_exists($item->getKey(), $this->items)) {
                throw new InvalidArgumentException(sprintf('Item with key "%s" already exists!', $item->getKey()));
            }
            $this->items[$item->getKey()] = $item;
        }

        return $this;
    }

    /**
     * Get current items
     *
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Set the "after" key that is used when inserting items
     *
     * @param string $key
     * @return $this
     */
    public function after(string $key): self
    {
        $this->after = $key;

        return $this;
    }
}
