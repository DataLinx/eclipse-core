<?php

namespace Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Foundation\Testing\TestsComponents;
use Eclipse\Core\View\Components\Form\File;

class FileTest extends PackageTestCase
{
    use InteractsWithViews,
        TestsComponents;

    public function setUp(): void
    {
        parent::setUp();

        $this->withViewErrors([]);
    }

    public function test_common_example_can_be_displayed(): void
    {
        $view = $this->blade('<x-form::file name="foo" label="Bar" help="Help text" required size="sm" wire:model="test" />');

        $view->assertSeeInOrder([
            'label', 'Bar', 'span class="required"', '/label',
            'name="foo"',
            'required',
            'aria-describedby',
            'form-control-sm',
            'wire:model="test"',
            'Help text',
        ], false)
            ->assertDontSee('is-invalid');
    }

    public function test_errors_can_be_displayed(): void
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
