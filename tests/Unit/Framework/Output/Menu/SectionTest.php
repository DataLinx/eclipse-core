<?php

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Output\Menu\Item;
use Eclipse\Core\Framework\Output\Menu\Section;

uses(PackageTestCase::class);

test('items can be added', function () {
    $section = new Section('Section label', null, 'section');

    expect($section->hasItems())->toBeFalse();

    $section->addItem(new Item('Some item', url('one')));
    $section->addItem(new Item('Other item', url('two')));

    expect($section->hasItems())->toBeTrue()
        ->and($section->getItems())->toHaveCount(2);
});

test('divider can be added', function () {
    $section = new Section('Section label', null, 'section');

    $section->addItem(new Item('Some item', url('one')));
    $section->addDivider();
    $section->addItem(new Item('Other item', url('two')));

    expect($section->getItems())->toHaveCount(3)
        ->and($section->getItems()[1])->toEqual('_divider_');
});
