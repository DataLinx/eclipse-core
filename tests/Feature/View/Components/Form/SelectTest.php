<?php

use Eclipse\Core\View\Components\Form\Select;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);

beforeEach(function () {
    $this->withViewErrors([]);
});

test('common example can be displayed', function () {
    // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
    $view = $this->blade('<x-form::select name="foo" label="Bar" :options="$options" default="2" help="Help text" required placeholder="Placeholder" size="sm" wire:model="test" />', [
        'options' => [
            1 => 'One',
            2 => 'Two',
        ],
    ]);

    $view->assertSee('name="foo"', false)
        ->assertSee('Bar')
        ->assertSee('One')
        ->assertSee('Two')
        ->assertSee('option value="2"  selected', false)
        ->assertSee('span class="required"', false)
        ->assertSee('aria-describedby')
        ->assertSee('Help text')
        ->assertSee('Placeholder')
        ->assertSee('form-select-sm')
        ->assertSeeInOrder([
            'label',
            'Bar',
            '<select',
            'class',
            'form-select',
            'wire:model="test"',
        ], false)
        ->assertDontSee('is-invalid');
});

test('errors can be displayed', function () {
    $this->withViewErrors([
        'foo' => 'Test error',
    ]);

    $view = $this->component(Select::class, [
        'name' => 'foo',
    ]);

    $view->assertSee('is-invalid')
        ->assertSee('invalid-feedback')
        ->assertSee('Test error');
});

test('can be displayed without options', function () {
    $view = $this->component(Select::class, [
        'name' => 'foo',
    ]);

    $view->assertSee('name="foo"', false)
        ->assertDontSee('label')
        ->assertSee('option value=""', false);
});

test('option groups can be displayed', function () {
    $view = $this->component(Select::class, [
        'name' => 'foo',
        'options' => [
            'Group One' => [
                1 => 'Option One',
                2 => 'Option Two',
            ],
            'Group Two' => [
                3 => 'Option Three',
                4 => 'Option Four',
            ],
            5 => 'Non-grouped Option Five',
        ],
    ]);

    $view->assertSee('optgroup label="Group One"', false)
        ->assertSee('Non-grouped Option Five', false)
        ->assertSeeInOrder([
            'Non-grouped Option Five',
            'Option One',
            'Option Three',
        ]);
});

test('multiple options can be preselected', function () {
    $view = $this->component(Select::class, [
        'name' => 'foo',
        'options' => [
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
        ],
        'default' => [1, 3],
        'multiple' => true,
    ]);

    $view->assertSee('name="foo"', false)
        ->assertSee('multiple')
        ->assertSee('One')
        ->assertSee('Two')
        ->assertSee('Three')
        ->assertSee('option value="1"  selected', false)
        ->assertDontSee('option value="2"  selected', false)
        ->assertSee('option value="3"  selected', false);
});
