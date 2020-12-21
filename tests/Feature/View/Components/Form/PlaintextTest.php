<?php

namespace Ocelot\Core\Tests\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\PackageTestCase;

class PlaintextTest extends PackageTestCase
{
    use InteractsWithViews;

    public function testStandard()
    {
        $view = $this->blade('<x-form::plaintext label="Foo" id="some-id">Bar</x-form::plaintext>');

        $view->assertSeeInOrder([
            '<label for="some-id">Foo</label>',
            '<div class="form-control-plaintext" id="some-id">Bar</div>',
        ], false);
    }

    public function testLabelSlot()
    {
        $view = $this->blade('<x-form::plaintext id="some-id">
                <x-slot name="label">Foo <b>Woo</b></x-slot>
                Bar
            </x-form::plaintext>');

        $view->assertSeeInOrder([
            '<label for="some-id">Foo <b>Woo</b></label>',
            '<div class="form-control-plaintext" id="some-id">Bar</div>',
        ], false);
    }
}
