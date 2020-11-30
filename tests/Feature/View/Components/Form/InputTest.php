<?php

namespace Ocelot\Core\Tests\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\View\Components\Form\Input;

class InputTest extends PackageTestCase
{
    use InteractsWithViews;

    public function setUp(): void
    {
        parent::setUp();

        $this->withViewErrors([]);
    }

    public function testStandard()
    {
        // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
        $view = $this->blade('<x-form::input name="foo" label="Bar" help="Help text" required placeholder="Placeholder" size="sm" prepend="www." append=".com" />', [

        ]);

        $view->assertSee('name="foo"', false)
             ->assertSee('Bar')
             ->assertSee('span class="required"', false)
             ->assertSee('aria-describedby')
             ->assertSee('Help text')
             ->assertSee('Placeholder')
             ->assertSee('input-size-sm')
             ->assertSeeInOrder([
                 'input-group-prepend',
                 'www.',
                 'input-group-append',
                 '.com',
             ])
             ->assertDontSee('is-invalid');
    }

    public function testWithError()
    {
        $this->withViewErrors([
            'foo' => 'Test error',
        ]);

        $view = $this->component(Input::class, [
            'name' => 'foo',
        ]);

        $view->assertSee('is-invalid')
             ->assertSee('invalid-feedback')
             ->assertSee('Test error');
    }
}