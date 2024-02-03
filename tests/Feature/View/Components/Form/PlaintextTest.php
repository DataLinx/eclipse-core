<?php

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);

test('common example can be displayed', function () {
    $view = $this->blade('<x-form::plaintext label="Foo" id="some-id">Bar</x-form::plaintext>');

    $view->assertSeeInOrder([
        '<label class="form-label" for="some-id">Foo</label>',
        '<div class="form-control-plaintext" id="some-id">Bar</div>',
    ], false);
});

test('label slot can be displayed', function () {
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
});
