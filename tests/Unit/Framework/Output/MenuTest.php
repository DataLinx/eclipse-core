<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Output\Menu;
use Eclipse\Core\Framework\Output\Menu\Item;
use Eclipse\Core\Framework\Output\Menu\Section;

uses(PackageTestCase::class);

test('items can added', function () {
    $menu = new Menu();

    $menu->addItem(new Item('Test item', 'test'));

    $section = new Section('Test section', null, 'section');
    $section->addItem(new Item('Another item', 'another-item'));
    $menu->addItem($section);

    $items = $menu->getItems();

    expect($items)->toHaveCount(2);
});

test('key collision can be detected', function () {
    $this->expectException(InvalidArgumentException::class);

    $menu = new Menu();

    $menu->addItem(new Item('Test item', 'test'));
    $menu->addItem(new Item('Test item', 'test'));
});

test('item can be inserted after another item', function () {
    $menu = new Menu();

    $menu->addItem(new Item('One', 'one'));
    $menu->addItem(new Item('Three', 'three'));
    $menu->after('one')->addItem(new Item('Two', 'two'));

    $items = $menu->getItems();

    expect($items)->toHaveCount(3)
        ->and($items['one']->getKey())->toEqual('one')
        ->and($items['two']->getKey())->toEqual('two')
        ->and($items['three']->getKey())->toEqual('three');

});

test('insertion exception can be caught', function () {
    $this->expectException(Exception::class);

    $menu = new Menu();

    $menu->addItem(new Item('Three', 'three'));

    $menu->after('one')->addItem(new Item('Two', 'two'));
});
