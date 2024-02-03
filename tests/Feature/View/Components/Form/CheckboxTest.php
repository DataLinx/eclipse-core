<?php

use Eclipse\Core\Foundation\Testing\TestsComponents;
use Eclipse\Core\View\Components\Form\Checkbox;
use Eclipse\Core\View\Components\Form\Radio;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);
uses(TestsComponents::class);

beforeEach(function () {
    $this->withViewErrors([]);
});

test('common example can be rendered', function () {
    // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
    $view = $this->blade('<x-form::checkbox name="foo" label="Bar" id="some-id" :options="$options" default="2" help="Help text" class="some-other-class" required inline wire:model="test" />', [
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
    ]);

    $view->assertSeeInOrder([
        'class',
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
        ->assertSee('type="checkbox"', false)
        ->assertSee('name="foo[]"', false)
        ->assertSeeInOrder([
            'wire:model="test"',
            'One',
            'checked',
            'wire:model="test"',
            'Two',
            'wire:model="test"',
            'Three',
        ], false)
        ->assertSee('form-check')
        ->assertDontSee('is-invalid');
});

test('error can be displayed', function () {
    $this->withViewErrors([
        'foo' => 'Test error',
    ]);

    $view = $this->component(Checkbox::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
        ],
    ]);

    $view->assertSeeInOrder([
        'is-invalid',
        'invalid-feedback',
        'Test error',
    ]);
});

test('multiple choices can be selected by default', function () {
    $view = $this->component(Checkbox::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
        'default' => [1, 3],
    ]);

    $view->assertSeeInOrder([
        'checked',
        'One',
        'Two',
        'checked',
        'Three',
    ]);
});

test('data can be repopulated from submit', function () {
    $this->mockSessionFlashedData([
        'foo' => [2, 3],
    ]);

    $view = $this->component(Checkbox::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
        'default' => 1,
    ]);

    $view->assertSeeInOrder([
        'One',
        'checked',
        'Two',
        'checked',
        'Three',
    ]);
});

test('can be displayed without defaults', function () {
    $view = $this->component(Checkbox::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
    ]);

    $view->assertDontSee('checked');
});

test('can be displayed as disabled', function () {
    $view = $this->component(Checkbox::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
        'disabled' => true,
    ]);

    $view->assertSee('disabled');
});

test('can be displayed as radio choices', function () {
    $view = $this->component(Radio::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
        'default' => 2,
    ]);

    $view->assertSee('type="radio"', false)
        ->assertSee('name="foo"', false)
        ->assertSeeInOrder([
            'One',
            'checked',
            'Two',
            'Three',
        ]);
});

test('can be displayed as buttons', function () {
    $view = $this->component(Checkbox::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
        'default' => 2,
        'asButtons' => true,
        'size' => 'sm',
    ]);

    $view->assertSeeInOrder([
        'btn-group',
        'btn-group-sm',
    ])->assertSeeInOrder([
        'One',
        'checked',
        'Two',
        'Three',
    ]);
});

test('can be displayed as switches', function () {
    $view = $this->component(Checkbox::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
        'default' => 2,
        'asSwitches' => true,
    ]);

    $view
        ->assertSee('form-switch')
        ->assertSeeInOrder([
            'One',
            'checked',
            'Two',
            'Three',
        ]);
});
