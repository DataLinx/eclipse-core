<?php

namespace Ocelot\Core\Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Ocelot\Core\Testing\PackageTestCase;
use Ocelot\Core\View\Components\Form\Hidden;

class HiddenTest extends PackageTestCase
{
    use InteractsWithViews;

    public function testStandard()
    {
        $view = $this->component(Hidden::class, [
            'name' => 'foo',
            'value' => 'bar',
        ]);

        $view->assertSeeInOrder([
            'name="foo"',
            'value="bar"',
        ], false);
    }

    public function testArray()
    {
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
    }

    public function testComplexArray()
    {
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
    }
}
