<?php

namespace Ocelot\Core\Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Foundation\Testing\PackageTestCase;
use Ocelot\Core\Foundation\Testing\TestsComponents;
use Ocelot\Core\View\Components\Form\Input;

class InputTest extends PackageTestCase
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
        // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
        $view = $this->blade('<x-form::input name="foo" label="Bar" help="Help text" required placeholder="Placeholder" size="sm" prepend="www." append=".com" />', [

        ]);

        $view->assertSee('name="foo"', false)
             ->assertSee('Bar')
             ->assertSee('span class="required"', false)
             ->assertSee('aria-describedby')
             ->assertSee('Help text')
             ->assertSee('Placeholder')
             ->assertSee('form-control-sm')
             ->assertSeeInOrder([
                 'input-group',
                 'input-group-text',
                 'www.',
                 '<input',
                 'input-group-text',
                 '.com',
             ], false)
             ->assertDontSee('is-invalid');
    }

    public function test_errors_can_be_displayed()
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

    public function test_can_repopulate_data_from_submit()
    {
        $this->mockSessionFlashedData([
            'foo' => 'Flashed',
        ]);

        $view = $this->component(Input::class, [
            'name' => 'foo',
            'default' => 'Saved',
        ]);

        $view->assertSee('Flashed')
             ->assertDontSee('Saved');
    }
}
