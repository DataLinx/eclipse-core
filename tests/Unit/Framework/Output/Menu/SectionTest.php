<?php

namespace Tests\Unit\Framework\Output\Menu;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Output\Menu\Item;
use Eclipse\Core\Framework\Output\Menu\Section;

/**
 * @covers \Eclipse\Core\Framework\Output\Menu\Section
 */
class SectionTest extends PackageTestCase
{
    /**
     * @return void
     */
    public function test_items_can_be_added(): void
    {
        $section = new Section('Section label', null, 'section');

        $this->assertFalse($section->hasItems());

        $section->addItem(new Item('Some item', url('one')));
        $section->addItem(new Item('Other item', url('two')));

        $this->assertTrue($section->hasItems());
        $this->assertCount(2, $section->getItems());
    }

    /**
     * @return void
     */
    public function test_divider_can_be_added(): void
    {
        $section = new Section('Section label', null, 'section');

        $section->addItem(new Item('Some item', url('one')));
        $section->addDivider();
        $section->addItem(new Item('Other item', url('two')));

        $this->assertCount(3, $section->getItems());
        $this->assertEquals('_divider_', $section->getItems()[1]);
    }
}
