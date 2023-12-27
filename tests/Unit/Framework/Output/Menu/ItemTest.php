<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\Output\Menu;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Output\Menu\Item;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorInterface;
use InvalidArgumentException;
use Mockery\MockInterface;

/**
 * @covers \Eclipse\Core\Framework\Output\Menu\Item
 */
class ItemTest extends PackageTestCase
{
    public function test_item_can_be_created(): void
    {
        // Minimal example
        $item = new Item('Test label', url('test'));

        $this->assertEquals('Test label', $item->getLabel());
        $this->assertEquals(url('test'), $item->getHref());

        // Example with both href and key
        $item = new Item('Test label', url('test'), 'test_key');

        $this->assertEquals('Test label', $item->getLabel());
        $this->assertEquals(url('test'), $item->getHref());
        $this->assertEquals('test_key', $item->getKey());

        // Example with only the key
        $item = new Item('Test label', null, 'test_key');

        $this->assertEquals('Test label', $item->getLabel());
        $this->assertEquals('test_key', $item->getKey());

        // Test exception
        $this->expectException(InvalidArgumentException::class);
        /** @noinspection PhpUnusedLocalVariableInspection */
        $item = new Item('Test label');
    }

    public function test_getters_and_setters_work(): void
    {
        $item = new Item('Test label', url('test'));

        $this->assertIsObject($item->setLabel('Another label'));
        $this->assertEquals('Another label', $item->getLabel());

        $this->assertIsObject($item->setHref(url('test-2')));
        $this->assertEquals(url('test-2'), $item->getHref());

        $this->assertIsObject($item->setKey('test_key'));
        $this->assertEquals('test_key', $item->getKey());

        $this->assertIsObject($item->setDisabled(true));
        $this->assertTrue($item->isDisabled());
    }

    public function test_current_item_can_be_detected(): void
    {
        $item = new Item('Test label', url('test'));
        $item2 = new Item('Another item', url('test-2'));

        $this->mock(UrlGeneratorInterface::class, function (MockInterface $mock) {
            $mock->shouldReceive('current')->andReturn(url('test'));
        });

        $this->assertTrue($item->isCurrent());
        $this->assertFalse($item2->isCurrent());
    }
}
