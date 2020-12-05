<?php

namespace Ocelot\Core\Tests\View\Components\Form;

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

    public function testStandard()
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
                'One',
                'checked',
                'Two',
                'Three',
            ])
            ->assertSee('custom-control-inline')
            ->assertDontSee('is-invalid');
    }

    public function testWithError()
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

    public function testMultipleDefaults()
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

    public function testRepopulate()
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

    public function testNoDefault()
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

    public function testDisabled()
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

    public function testRadioVariant()
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

    public function testAsButtons()
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
            'active',
            'checked',
            'Two',
            'Three'
        ]);
    }
}
