<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Output\Menu\Item;
use Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorInterface;
use Mockery\MockInterface;

uses(PackageTestCase::class);

test('item can be created', function () {
    // Minimal example
    $item = new Item('Test label', url('test'));

    expect($item->getLabel())->toEqual('Test label')
        ->and($item->getHref())->toEqual(url('test'));

    // Example with both href and key
    $item = new Item('Test label', url('test'), 'test_key');

    expect($item->getLabel())->toEqual('Test label')
        ->and($item->getHref())->toEqual(url('test'))
        ->and($item->getKey())->toEqual('test_key');

    // Example with only the key
    $item = new Item('Test label', null, 'test_key');

    expect($item->getLabel())->toEqual('Test label')
        ->and($item->getKey())->toEqual('test_key');

    // Test exception
    $this->expectException(InvalidArgumentException::class);

    /** @noinspection PhpUnusedLocalVariableInspection */
    $item = new Item('Test label');
});

test('getters and setters work', function () {
    $item = new Item('Test label', url('test'));

    expect($item->setLabel('Another label'))->toBeObject()
        ->and($item->getLabel())->toEqual('Another label')
        ->and($item->setHref(url('test-2')))->toBeObject()
        ->and($item->getHref())->toEqual(url('test-2'))
        ->and($item->setKey('test_key'))->toBeObject()
        ->and($item->getKey())->toEqual('test_key')
        ->and($item->setDisabled(true))->toBeObject()
        ->and($item->isDisabled())->toBeTrue();

});

test('current item can be detected', function () {
    $item = new Item('Test label', url('test'));
    $item2 = new Item('Another item', url('test-2'));

    $this->mock(UrlGeneratorInterface::class, function (MockInterface $mock) {
        $mock->allows('current')->andReturns(url('test'));
    });

    expect($item->isCurrent())->toBeTrue()
        ->and($item2->isCurrent())->toBeFalse();
});
