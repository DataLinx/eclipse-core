<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\Output;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Output\Toast;

/**
 * @covers \Eclipse\Core\Framework\Output\Toast
 */
class ToastTest extends PackageTestCase
{
    public function test_toast_can_be_created(): void
    {
        $toast = new Toast('Some message', 'Some title');

        $this->assertEquals('Some message', $toast->getMessage());
        $this->assertEquals('Some title', $toast->getTitle());
        $this->assertEquals('info', $toast->getType());
        $this->assertEquals('info-circle', $toast->getIcon());
        $this->assertFalse($toast->isSticky());
        $this->assertFalse($toast->hasLinks());
        $this->assertNull($toast->getLinks());

        // Test basic setters
        $toast->title('Some other title');
        $this->assertEquals('Some other title', $toast->getTitle());

        $toast->icon('test');
        $this->assertEquals('test', $toast->getIcon());

        $toast->sticky();
        $this->assertTrue($toast->isSticky());
    }

    public function test_type_can_be_set(): void
    {
        $toast = new Toast('Some message');

        foreach (['success', 'danger', 'warning', 'info'] as $type) {
            $toast->$type();

            $this->assertEquals($type, $toast->getType());

            $this->assertEquals(match ($type) {
                'success' => _('Success'),
                'danger' => _('Error'),
                'warning' => _('Warning'),
                'info' => _('Notice'),
            }, $toast->getTitle());

            $this->assertEquals(match ($type) {
                'success' => 'check',
                'danger' => 'exclamation-circle',
                'warning' => 'exclamation-triangle',
                'info' => 'info-circle',
            }, $toast->getIcon());
        }
    }

    public function test_links_can_be_added(): void
    {
        $toast = new Toast('Some message');

        $toast->link('Some label', 'link');
        $toast->link('Another label', 'link-2');

        $this->assertTrue($toast->hasLinks());
        $this->assertCount(2, $toast->getLinks());
    }
}
