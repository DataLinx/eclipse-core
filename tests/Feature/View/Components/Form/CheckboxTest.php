<?php

namespace Ocelot\Core\Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\TestsComponents;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\View\Components\Form\Checkbox;
use Ocelot\Core\View\Components\Form\Radio;

class CheckboxTest extends PackageTestCase
{
    use InteractsWithViews,
        TestsComponents;

    public function setUp(): void
    {
        parent::setUp();

        $this->withViewErrors([]);
    }

    public function test_common_example_can_be_rendered()
    {
        // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
        $view = $this->blade('<x-form::checkbox name="foo" label="Bar" id="some-id" :options="$options" default="2" help="Help text" class="some-other-class" required inline />', [
            'options' => [
                1 => 'One',
                2 => 'Two',
                3 => 'Three',
            ],
        ]);

        $view->assertSeeInOrder([
                'class',
                'mb-3',
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
                'One',
                'checked',
                'Two',
                'Three',
            ])
            ->assertSee('form-check')
            ->assertDontSee('is-invalid');
    }

    public function test_error_can_be_displayed()
    {
        $this->withViewErrors([
            'foo' => 'Test error',
        ]);

        $view = $this->component(Checkbox::class, [
            'name' => 'foo',
        ]);

        $view->assertSeeInOrder([
            'is-invalid',
            'invalid-feedback',
            'Test error',
        ]);
    }

    public function test_multiple_choices_can_be_selected_by_default()
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

    public function test_data_can_be_repopulated_from_submit()
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

    public function test_can_be_displayed_without_defaults()
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

    public function test_can_be_displayed_as_disabled()
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

    public function test_can_be_displayed_as_radio_choices()
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

    public function test_can_be_displayed_as_buttons()
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

    public function test_can_be_displayed_as_switches()
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
