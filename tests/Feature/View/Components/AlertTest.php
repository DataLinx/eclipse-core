<?php

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);

test('common example can be displayed', function () {
    $view = $this->blade('<x-alert heading="Foo">
                <p>Bar</p>
            </x-alert>');

    $view->assertSeeInOrder([
        'alert-info',
        '<h4 class="alert-heading">',
        'circle-info',
        'Foo',
        '</h4>',
        '<p>Bar</p>',
    ], false)
        ->assertDontSee('alert-dismissible')
        ->assertDontSee('button');
});

test('dismissible example can be displayed', function () {
    $view = $this->blade('<x-alert type="success" dismissible id="some-id" icon="rabbit">
                <x-slot:heading>Foo</x-slot:heading>
                <p>Bar</p>
            </x-alert>');

    $view->assertSeeInOrder([
        'alert-success',
        'alert-dismissible',
        'id="some-id"',
        'button',
        '<h4 class="alert-heading">',
        'rabbit',
        'Foo',
        '</h4>',
        '<p>Bar</p>',
    ], false);
});
