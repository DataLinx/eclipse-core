<?php

use Eclipse\Core\Foundation\Testing\TestsComponents;
use Eclipse\Core\View\Components\Form\File;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);
uses(TestsComponents::class);

beforeEach(function () {
    $this->withViewErrors([]);
});

test('common example can be displayed', function () {
    $view = $this->blade('<x-form::file name="foo" label="Bar" help="Help text" required size="sm" wire:model="test" />');

    $view->assertSeeInOrder([
        'label', 'Bar', 'span class="required"', '/label',
        'name="foo"',
        'required',
        'aria-describedby',
        'form-control-sm',
        'wire:model="test"',
        'Help text',
    ], false)
        ->assertDontSee('is-invalid');
});

test('errors can be displayed', function () {
    $this->withViewErrors([
        'foo' => 'Test error',
    ]);

    $view = $this->component(File::class, [
        'name' => 'foo',
    ]);

    $view->assertSee('is-invalid')
        ->assertSee('invalid-feedback')
        ->assertSee('Test error');
});
