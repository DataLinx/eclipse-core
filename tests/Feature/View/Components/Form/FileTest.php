<?php

namespace Ocelot\Core\Tests\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\Testing\TestsComponents;
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

    public function testStandard()
    {
        $view = $this->blade('<x-form::file name="foo" label="Bar" help="Help text" required placeholder="Placeholder" size="sm" />');

        $view->assertSeeInOrder([
            'label', 'Bar', 'span class="required"', '/label',
            'form-control-sm',
            'name="foo"',
            'custom-file-input',
            'required',
            'aria-describedby',
            'Placeholder',
            'Help text',
        ], false)
            ->assertDontSee('is-invalid');
    }

    public function testWithError()
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
