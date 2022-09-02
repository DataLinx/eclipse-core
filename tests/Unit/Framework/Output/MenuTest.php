<?php declare(strict_types=1);

namespace SDLX\Core\Tests\Unit\Framework\Output;

use Exception;
use InvalidArgumentException;
use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\Framework\Output\Menu;

/**
 * @covers \SDLX\Core\Framework\Output\Menu
 */
class MenuTest extends PackageTestCase
{
    /**
     * @return void
     * @throws Exception
     */
    public function test_items_can_added(): void
    {
        $menu = new Menu();

        $menu->addItem(new Menu\Item('Test item', 'test'));

        $items = $menu->getItems();

        $this->assertCount(1, $items);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_key_collision_can_be_detected(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $menu = new Menu();

        $menu->addItem(new Menu\Item('Test item', 'test'));
        $menu->addItem(new Menu\Item('Test item', 'test'));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_item_can_be_inserted_after_another_item(): void
    {
        $menu = new Menu();

        $menu->addItem(new Menu\Item('One', 'one'));
        $menu->addItem(new Menu\Item('Three', 'three'));
        $menu->after('one')->addItem(new Menu\Item('Two', 'two'));

        $items = $menu->getItems();

        $this->assertCount(3, $items);

        $this->assertEquals('one', $items['one']->getKey());
        $this->assertEquals('two', $items['two']->getKey());
        $this->assertEquals('three', $items['three']->getKey());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function test_insertion_exception_can_be_caught(): void
    {
        $this->expectException(Exception::class);

        $menu = new Menu();

        $menu->addItem(new Menu\Item('Three', 'three'));

        $menu->after('one')->addItem(new Menu\Item('Two', 'two'));
    }
}
