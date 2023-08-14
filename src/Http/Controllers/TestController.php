<?php

namespace Eclipse\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Eclipse\Core\Foundation\Http\Controllers\AbstractController;
use Eclipse\Core\Framework\Output\Menu;

class TestController extends AbstractController
{
    public function components(Menu $menu): Renderable
    {
        // Add sample nav menu entries
        $test = new Menu\Section('Test section', null, 'test-section');
        $test->addItem(new Menu\Item('One', 'one'));
        $test->addItem(new Menu\Item('Two', 'two'));

        $sub = new Menu\Section('Sub section example', null, 'sub-section');
        $sub->addItem(new Menu\Item('Three', 'three'));
        $sub->addItem(new Menu\Item('Four', 'four'));
        $sub->addItem(new Menu\Item('Five', 'five'));
        $test->addItem($sub);

        $test->addItem(new Menu\Item('Six', 'six'));
        $test->addDivider();
        $test->addItem(new Menu\Item('Seven', 'seven'));

        $menu->after(url('users'))->addItem($test);

        // Render test view
        return view('core::test.components');
    }
}
