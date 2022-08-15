<?php

namespace Ocelot\Core\Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Foundation\Testing\PackageTestCase;
use Ocelot\Core\Foundation\Testing\TestsComponents;
use Ocelot\Core\View\Components\Form\File;

class FileTest extends PackageTestCase
{
    use InteractsWithViews,
        TestsComponents;

    public function setUp(): void
    {
        parent::setUp();

        $this->withViewErrors([]);
    }

    public function test_common_example_can_be_displayed()
    {
        $view = $this->blade('<x-form::file name="foo" label="Bar" help="Help text" required size="sm" />');

        $view->assertSeeInOrder([
            'label', 'Bar', 'span class="required"', '/label',
            'name="foo"',
            'form-control-sm',
            'required',
            'aria-describedby',
            'Help text',
        ], false)
            ->assertDontSee('is-invalid');
    }

    public function test_errors_can_be_displayed()
    {
        $this->withViewErrors([
            'foo' => 'Test error',
        ]);

        $view = $this->component(File::class, [
            'name' => 'foo',
        ]);

        $view->assertSee('is-invalid')
             ->assertSee('invalid-feedback')
             ->assertSee('Test error');
    }
}
