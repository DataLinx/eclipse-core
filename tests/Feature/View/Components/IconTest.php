<?php

namespace Ocelot\Core\Tests\Feature\View\Components;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\View\Components\Icon;

class IconTest extends PackageTestCase
{
    use InteractsWithViews;

    public function test_minimal_example_can_be_displayed()
    {
        $view = $this->component(Icon::class, [
            'name' => 'user',
        ]);

        $view->assertSeeInOrder([
            '<i',
            'fa',
            'fa-user'
        ], false)->assertDontSee('text-');
    }

    public function test_full_example_can_be_displayed()
    {
        $view = $this->blade('<x-icon name="user" pack="fal" color="success" class="fa-10x" id="some-id"/>');

        $view->assertSeeInOrder([
            '<i',
            'fal',
            'fa-user',
            'text-success',
            'fa-10x',
            'id="some-id"',
        ], false);
    }
}
