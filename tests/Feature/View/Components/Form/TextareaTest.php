<?php

namespace Ocelot\Core\Tests\Feature\View\Components\Form;


use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\Testing\TestsComponents;
use Ocelot\Core\View\Components\Form\Textarea;

class TextareaTest extends PackageTestCase
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
        $view = $this->blade('<x-form::textarea name="foo" label="Bar" help="Help text" required placeholder="Placeholder" rows="10" />');

        $view->assertSee('name="foo"', false)
            ->assertSee('Bar')
            ->assertSee('span class="required"', false)
            ->assertSee('aria-describedby')
            ->assertSee('Help text')
            ->assertSee('Placeholder')
            ->assertSee('rows="10"', false)
            ->assertDontSee('is-invalid');
    }

    public function testWithError()
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

    public function testRepopulate()
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
