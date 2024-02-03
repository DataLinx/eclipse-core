<?php

use Eclipse\Core\Foundation\Testing\TestsComponents;
use Eclipse\Core\View\Components\Form\Textarea;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);
uses(TestsComponents::class);

beforeEach(function () {
    $this->withViewErrors([]);
});

test('common example can be displayed', function () {
    // We have to use the blade() method, since component() does not pass the additional simple attributes, e.g. "required"
    $view = $this->blade('<x-form::textarea name="foo" label="Bar" help="Help text" required placeholder="Placeholder" rows="10" wire:model="test" />');

    $view->assertSee('name="foo"', false)
        ->assertSee('Bar')
        ->assertSee('span class="required"', false)
        ->assertSee('aria-describedby')
        ->assertSee('Help text')
        ->assertSee('Placeholder')
        ->assertSee('rows="10"', false)
        ->assertSeeInOrder([
            'label',
            'Bar',
            '<textarea',
            'wire:model="test"',
        ], false)
        ->assertDontSee('is-invalid');
});

test('error can be displayed', function () {
    $this->withViewErrors([
        'foo' => 'Test error',
    ]);

    $view = $this->component(Textarea::class, [
        'name' => 'foo',
    ]);

    $view->assertSee('is-invalid')
        ->assertSee('invalid-feedback')
        ->assertSee('Test error');
});

test('submitted data can be initialized', function () {
    $this->mockSessionFlashedData([
        'foo' => 'Flashed',
    ]);

    $view = $this->component(Textarea::class, [
        'name' => 'foo',
        'default' => 'Saved',
    ]);

    $view->assertSee('Flashed')
        ->assertDontSee('Saved');
});
