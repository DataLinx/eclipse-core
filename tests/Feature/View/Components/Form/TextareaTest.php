<?php

namespace SDLX\Core\Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\Foundation\Testing\TestsComponents;
use SDLX\Core\View\Components\Form\Textarea;

class TextareaTest extends PackageTestCase
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
        // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
        $view = $this->blade('<x-form::textarea name="foo" label="Bar" help="Help text" required placeholder="Placeholder" rows="10" wire:model="test" />');

        $view->assertSee('name="foo"', false)
            ->assertSee('Bar')
            ->assertSee('span class="required"', false)
            ->assertSee('aria-describedby')
            ->assertSee('Help text')
            ->assertSee('Placeholder')
            ->assertSee('rows="10"', false)
            ->assertSeeInOrder([
                'label',
                'Bar',
                '<textarea',
                'wire:model="test"',
            ], false)
            ->assertDontSee('is-invalid');
    }

    public function test_error_can_be_displayed(): void
    {
        $this->withViewErrors([
            'foo' => 'Test error',
        ]);

        $view = $this->component(Textarea::class, [
            'name' => 'foo',
        ]);

        $view->assertSee('is-invalid')
             ->assertSee('invalid-feedback')
             ->assertSee('Test error');
    }

    public function test_submitted_data_can_be_initialized(): void
    {
        $this->mockSessionFlashedData([
            'foo' => 'Flashed',
        ]);

        $view = $this->component(Textarea::class, [
            'name' => 'foo',
            'default' => 'Saved',
        ]);

        $view->assertSee('Flashed')
             ->assertDontSee('Saved');
    }
}
