<?php

use Eclipse\Core\View\Components\Form\Hidden;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);

test('common example can be displayed', function () {
    $view = $this->component(Hidden::class, [
        'name' => 'foo',
        'value' => 'bar',
    ]);

    $view->assertSeeInOrder([
        'name="foo"',
        'value="bar"',
    ], false);
});

test('multiple values can be displayed', function () {
    $view = $this->component(Hidden::class, [
        'data' => [
            'one' => 'two',
            'three' => [
                'four',
                'five',
            ],
        ],
    ]);

    $view->assertSeeInOrder([
        'name="one"',
        'value="two"',
        'name="three[]"',
        'value="four"',
        'name="three[]"',
        'value="five"',
    ], false);
});

test('multidimensional arrays can be displayed', function () {
    $view = $this->component(Hidden::class, [
        'data' => [
            'six' => [
                'seven' => 'eight',
                'nine' => 'ten',
                'eleven' => [
                    'twelve' => 'thirteen',
                    'fourteen' => 'fifteen',
                ],
            ],
        ],
    ]);

    $view->assertSeeInOrder([
        'name="six[seven]"',
        'value="eight"',
        'name="six[nine]"',
        'value="ten"',
        'name="six[eleven][twelve]"',
        'value="thirteen"',
        'name="six[eleven][fourteen]"',
        'value="fifteen"',
    ], false);
});
