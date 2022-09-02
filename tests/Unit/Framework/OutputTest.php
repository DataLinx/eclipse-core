<?php declare(strict_types=1);

namespace SDLX\Core\Tests\Unit\Framework;

use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\Framework\Output;

/**
 * @covers \SDLX\Core\Framework\Output
 */
class OutputTest extends PackageTestCase
{
    public function test_toasts_can_be_added(): void
    {
        /** @var Output $output */
        $output = app(Output::class);

        $this->assertEmpty($output->getToasts());

        $toast = $output->toast('Some toast message');

        $this->assertEquals('Some toast message', $toast->getMessage());

        $toasts = $output->getToasts();
        $this->assertCount(1, $toasts);
    }
}