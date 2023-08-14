<?php

namespace Eclipse\Core\Tests\Feature\View\Components\Form;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\View\Components\Form\Hidden;

class HiddenTest extends PackageTestCase
{
    use InteractsWithViews;

    public function test_common_example_can_be_displayed()
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

    public function test_multiple_values_can_be_displayed()
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

    public function test_multidimensional_arrays_can_be_displayed()
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
