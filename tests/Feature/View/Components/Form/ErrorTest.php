<?php

use Eclipse\Core\View\Components\Form\Error;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);

test('common example can be rendered', function () {
    $this->withViewErrors([
        'foo' => 'Test error',
        'bar' => 'Another error',
    ]);

    $view = $this->component(Error::class);

    $view->assertSeeInOrder([
        'alert alert-danger',
        'Test error',
        'hr',
        'Another error',
    ]);
});
