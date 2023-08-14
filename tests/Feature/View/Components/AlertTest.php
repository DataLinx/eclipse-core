<?php

namespace Eclipse\Core\Tests\Feature\View\Components;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Eclipse\Core\Foundation\Testing\PackageTestCase;

class AlertTest extends PackageTestCase
{
    use InteractsWithViews;

    public function test_common_example_can_be_displayed()
    {
        $view = $this->blade('<x-alert heading="Foo">
                <p>Bar</p>
            </x-alert>');

        $view->assertSeeInOrder([
            'alert-primary',
            '<h4 class="alert-heading">Foo</h4>',
            '<p>Bar</p>',
        ], false)
            ->assertDontSee('alert-dismissible')
            ->assertDontSee('button');
    }

    public function test_dismissible_example_can_be_displayed()
    {
        $view = $this->blade('<x-alert type="success" dismissible id="some-id">
                <x-slot name="heading">Foo</x-slot>
                <p>Bar</p>
            </x-alert>');

        $view->assertSeeInOrder([
            'alert-success',
            'alert-dismissible',
            'id="some-id"',
            'button',
            '<h4 class="alert-heading">Foo</h4>',
            '<p>Bar</p>'
        ], false);
    }
}
