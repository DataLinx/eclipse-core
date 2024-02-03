<?php

use Eclipse\Core\Foundation\Testing\TestsComponents;
use Eclipse\Core\View\Components\Form\Switcher;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);
uses(TestsComponents::class);

beforeEach(function () {
    $this->withViewErrors([]);
});

test('common example can be displayed', function () {
    // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
    $view = $this->blade('<x-form::switcher name="foo" label="Bar" default="1" help="Help text" id="some-id" class="some-other-class" required data-foo="bar" wire:model="test"/>');

    $view->assertSeeInOrder([
        'class=',
        'form-group',
        'some-other-class',
    ])
        ->assertSeeInOrder([
            'aria-describedby="some-id-help',
            'id="some-id-help"',
            'Help text',
        ], false)
        ->assertSeeInOrder([
            'label',
            'Bar',
            'class="required"',
        ], false)
        ->assertSeeInOrder([
            'name="foo"',
            'value="1"',
            'checked',
            'required',
        ], false)
        ->assertSeeInOrder([
            '<input',
            'name="foo"',
            'class="form-check-input"',
            'wire:model="test"',
        ], false)
        ->assertDontSee('is-invalid');
});

test('errors can be displayed', function () {
    $this->withViewErrors([
        'foo' => 'Test error',
    ]);

    $view = $this->component(Switcher::class, [
        'name' => 'foo',
    ]);

    $view->assertSeeInOrder([
        'is-invalid',
        'invalid-feedback',
        'Test error',
    ]);
});

test('checked state can be initialized', function () {
    $this->mockSessionFlashedData([
        'foo' => '1',
    ]);

    $view = $this->component(Switcher::class, [
        'name' => 'foo',
        'default' => 0,
    ]);

    $view->assertSee('checked');
});

test('unchecked state can be initialized', function () {
    $this->mockSessionFlashedData([
        'foo' => '0',
    ]);

    $view = $this->component(Switcher::class, [
        'name' => 'foo',
        'default' => 1,
    ]);

    $view->assertDontSee('checked');
});

test('can display as disabled', function () {
    $view = $this->component(Switcher::class, [
        'name' => 'foo',
        'disabled' => true,
    ]);

    $view->assertSee('disabled');
});
