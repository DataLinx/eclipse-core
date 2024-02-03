<?php

use Eclipse\Core\Foundation\Testing\TestsComponents;
use Eclipse\Core\View\Components\Form\Input;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);
uses(TestsComponents::class);

beforeEach(function () {
    $this->withViewErrors([]);
});

test('common example can be displayed', function () {
    // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
    $view = $this->blade('<x-form::input name="foo" label="Bar" help="Help text" required placeholder="Placeholder" size="sm" prepend="www." append=".com" wire:model="test" />', [

    ]);

    $view->assertSee('name="foo"', false)
        ->assertSee('Bar')
        ->assertSee('span class="required"', false)
        ->assertSee('aria-describedby')
        ->assertSee('Help text')
        ->assertSee('Placeholder')
        ->assertSee('form-control-sm')
        ->assertSeeInOrder([
            'input-group',
            'input-group-text',
            'www.',
            '<input',
            'class',
            'form-control',
            'wire:model="test"',
            'input-group-text',
            '.com',
        ], false)
        ->assertDontSee('is-invalid');
});

test('errors can be displayed', function () {
    $this->withViewErrors([
        'foo' => 'Test error',
    ]);

    $view = $this->component(Input::class, [
        'name' => 'foo',
    ]);

    $view->assertSee('is-invalid')
        ->assertSee('invalid-feedback')
        ->assertSee('Test error');
});

test('can repopulate data from submit', function () {
    $this->mockSessionFlashedData([
        'foo' => 'Flashed',
    ]);

    $view = $this->component(Input::class, [
        'name' => 'foo',
        'default' => 'Saved',
    ]);

    $view->assertSee('Flashed')
        ->assertDontSee('Saved');
});
