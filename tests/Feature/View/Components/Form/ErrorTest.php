<?php

namespace Ocelot\Core\Tests\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\View\Components\Form\Error;

class ErrorTest extends PackageTestCase
{
    use InteractsWithViews;

    public function testStandard()
    {
        $this->withViewErrors([
            'foo' => 'Test error',
            'bar' => 'Another error',
        ]);

        $view = $this->component(Error::class);

        $view->assertSeeInOrder([
            'Test error',
            'Another error',
        ]);
    }
}
