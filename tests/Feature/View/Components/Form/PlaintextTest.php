<?php

namespace Tests\Feature\View\Components\Form;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

class PlaintextTest extends PackageTestCase
{
    use InteractsWithViews;

    public function test_common_example_can_be_displayed()
    {
        $view = $this->blade('<x-form::plaintext label="Foo" id="some-id">Bar</x-form::plaintext>');

        $view->assertSeeInOrder([
            '<label class="form-label" for="some-id">Foo</label>',
            '<div class="form-control-plaintext" id="some-id">Bar</div>',
        ], false);
    }

    public function test_label_slot_can_be_displayed()
    {
        $view = $this->blade('<x-form::plaintext>
                <x-slot name="label">Foo <b>Woo</b></x-slot>
                Bar
            </x-form::plaintext>');

        $view->assertSeeInOrder([
            '<label class="form-label" for="plaintext-',
            'Foo <b>Woo</b></label>',
            '<div class="form-control-plaintext" id="plaintext-',
            'Bar</div>',
        ], false);
    }
}
