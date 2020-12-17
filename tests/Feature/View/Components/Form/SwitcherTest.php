<?php

namespace Ocelot\Core\Tests\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\Testing\TestsComponents;
use Ocelot\Core\View\Components\Form\Switcher;

class SwitcherTest extends PackageTestCase
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
        $view = $this->blade('<x-form::switcher name="foo" label="Bar" default="1" help="Help text" id="some-id" class="some-other-class" required data-foo="bar" />');

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
            ->assertDontSee('is-invalid');
    }

    public function testWithError()
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

    public function testRepopulate()
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

    public function testClear()
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

    public function testDisabled()
    {
        $view = $this->component(Switcher::class, [
            'name' => 'foo',
            'disabled' => true,
        ]);

        $view->assertSee('disabled');
    }
}