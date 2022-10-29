<?php

namespace SDLX\Core\Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\Foundation\Testing\TestsComponents;
use SDLX\Core\View\Components\Form\Checkbox;
use SDLX\Core\View\Components\Form\Radio;

class CheckboxTest extends PackageTestCase
{
    use InteractsWithViews,
        TestsComponents;

    public function setUp(): void
    {
        parent::setUp();

        $this->withViewErrors([]);
    }

    public function test_common_example_can_be_rendered(): void
    {
        // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
        $view = $this->blade('<x-form::checkbox name="foo" label="Bar" id="some-id" :options="$options" default="2" help="Help text" class="some-other-class" required inline wire:model="test" />', [
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
        ]);

        $view->assertSeeInOrder([
                'class',
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
            ->assertSee('type="checkbox"', false)
            ->assertSee('name="foo[]"', false)
            ->assertSeeInOrder([
                'wire:model="test"',
                'One',
                'checked',
                'wire:model="test"',
                'Two',
                'wire:model="test"',
                'Three',
            ], false)
            ->assertSee('form-check')
            ->assertDontSee('is-invalid');
    }

    public function test_error_can_be_displayed(): void
    {
        $this->withViewErrors([
            'foo' => 'Test error',
        ]);

        $view = $this->component(Checkbox::class, [
            'name' => 'foo',
            'options' => [
                1 => 'One',
                2 => 'Two',
            ],
        ]);

        $view->assertSeeInOrder([
            'is-invalid',
            'invalid-feedback',
            'Test error',
        ]);
    }

    public function test_multiple_choices_can_be_selected_by_default(): void
    {
        $view = $this->component(Checkbox::class, [
            'name' => 'foo',
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
            'default' => [1, 3],
        ]);

        $view->assertSeeInOrder([
            'checked',
            'One',
            'Two',
            'checked',
            'Three',
        ]);
    }

    public function test_data_can_be_repopulated_from_submit(): void
    {
        $this->mockSessionFlashedData([
            'foo' => [2, 3],
        ]);

        $view = $this->component(Checkbox::class, [
            'name' => 'foo',
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
            'default' => 1,
        ]);

        $view->assertSeeInOrder([
            'One',
            'checked',
            'Two',
            'checked',
            'Three',
        ]);
    }

    public function test_can_be_displayed_without_defaults(): void
    {
        $view = $this->component(Checkbox::class, [
            'name' => 'foo',
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
        ]);

        $view->assertDontSee('checked');
    }

    public function test_can_be_displayed_as_disabled(): void
    {
        $view = $this->component(Checkbox::class, [
            'name' => 'foo',
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
            'disabled' => true,
        ]);

        $view->assertSee('disabled');
    }

    public function test_can_be_displayed_as_radio_choices(): void
    {
        $view = $this->component(Radio::class, [
            'name' => 'foo',
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
            'default' => 2,
        ]);

        $view->assertSee('type="radio"', false)
             ->assertSee('name="foo"', false)
             ->assertSeeInOrder([
                'One',
                'checked',
                'Two',
                'Three',
            ]);
    }

    public function test_can_be_displayed_as_buttons(): void
    {
        $view = $this->component(Checkbox::class, [
            'name' => 'foo',
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
            'default' => 2,
            'asButtons' => true,
            'size' => 'sm',
        ]);

        $view->assertSeeInOrder([
            'btn-group',
            'btn-group-sm',
        ])->assertSeeInOrder([
            'One',
            'checked',
            'Two',
            'Three'
        ]);
    }

    public function test_can_be_displayed_as_switches(): void
    {
        $view = $this->component(Checkbox::class, [
            'name' => 'foo',
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
            'default' => 2,
            'asSwitches' => true,
        ]);

        $view
            ->assertSee('form-switch')
            ->assertSeeInOrder([
                'One',
                'checked',
                'Two',
                'Three'
            ]);
    }
}
