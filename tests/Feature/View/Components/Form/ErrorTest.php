<?php

namespace SDLX\Core\Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\View\Components\Form\Error;

class ErrorTest extends PackageTestCase
{
    use InteractsWithViews;

    public function test_common_example_can_be_rendered()
    {
        $this->withViewErrors([
            'foo' => 'Test error',
            'bar' => 'Another error',
        ]);

        $view = $this->component(Error::class);

        $view->assertSeeInOrder([
            'alert alert-danger',
            'Test error',
            'hr',
            'Another error',
        ]);
    }
}
