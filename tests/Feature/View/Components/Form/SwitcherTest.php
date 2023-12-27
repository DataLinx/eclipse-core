<?php

namespace Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Foundation\Testing\TestsComponents;
use Eclipse\Core\View\Components\Form\Switcher;

class SwitcherTest extends PackageTestCase
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
        $view = $this->blade('<x-form::switcher name="foo" label="Bar" default="1" help="Help text" id="some-id" class="some-other-class" required data-foo="bar" wire:model="test"/>');

        $view->assertSeeInOrder([
            'class=',
            'form-group',
            'some-other-class',
        ])
            ->assertSeeInOrder([
                'aria-describedby="some-id-help',
                'id="some-id-help"',
                'Help text',
            ], false)
            ->assertSeeInOrder([
                'label',
                'Bar',
                'class="required"',
            ], false)
            ->assertSeeInOrder([
                'name="foo"',
                'value="1"',
                'checked',
                'required',
            ], false)
            ->assertSeeInOrder([
                '<input',
                'name="foo"',
                'class="form-check-input"',
                'wire:model="test"',
            ], false)
            ->assertDontSee('is-invalid');
    }

    public function test_errors_can_be_displayed(): void
    {
        $this->withViewErrors([
            'foo' => 'Test error',
        ]);

        $view = $this->component(Switcher::class, [
            'name' => 'foo',
        ]);

        $view->assertSeeInOrder([
            'is-invalid',
            'invalid-feedback',
            'Test error',
        ]);
    }

    public function test_checked_state_can_be_initialized(): void
    {
        $this->mockSessionFlashedData([
            'foo' => '1',
        ]);

        $view = $this->component(Switcher::class, [
            'name' => 'foo',
            'default' => 0,
        ]);

        $view->assertSee('checked');
    }

    public function test_unchecked_state_can_be_initialized(): void
    {
        $this->mockSessionFlashedData([
            'foo' => '0',
        ]);

        $view = $this->component(Switcher::class, [
            'name' => 'foo',
            'default' => 1,
        ]);

        $view->assertDontSee('checked');
    }

    public function test_can_display_as_disabled(): void
    {
        $view = $this->component(Switcher::class, [
            'name' => 'foo',
            'disabled' => true,
        ]);

        $view->assertSee('disabled');
    }
}
