<?php

use Eclipse\Core\View\Components\Icon;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);

test('minimal example can be displayed', function () {
    $view = $this->component(Icon::class, [
        'name' => 'user',
    ]);

    $view->assertSeeInOrder([
        '<i',
        'fa',
        'fa-user',
    ], false)->assertDontSee('text-');
});

test('full example can be displayed', function () {
    $view = $this->blade('<x-icon name="user" pack="fal" color="success" class="fa-10x" id="some-id"/>');

    $view->assertSeeInOrder([
        '<i',
        'fal',
        'fa-user',
        'text-success',
        'fa-10x',
        'id="some-id"',
    ], false);
});
