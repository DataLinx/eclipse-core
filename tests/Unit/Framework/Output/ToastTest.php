<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Output\Toast;

uses(PackageTestCase::class);

test('toast can be created', function () {
    $toast = new Toast('Some message', 'Some title');

    expect($toast->getMessage())->toEqual('Some message')
        ->and($toast->getTitle())->toEqual('Some title')
        ->and($toast->getType())->toEqual('info')
        ->and($toast->getIcon())->toEqual('info-circle')
        ->and($toast->isSticky())->toBeFalse()
        ->and($toast->hasLinks())->toBeFalse()
        ->and($toast->getLinks())->toBeNull();

    // Test basic setters
    $toast->title('Some other title');
    expect($toast->getTitle())->toEqual('Some other title');

    $toast->icon('test');
    expect($toast->getIcon())->toEqual('test');

    $toast->sticky();
    expect($toast->isSticky())->toBeTrue();
});

test('type can be set', function () {
    $toast = new Toast('Some message');

    foreach (['success', 'danger', 'warning', 'info'] as $type) {
        $toast->$type();

        expect($toast->getType())->toEqual($type)
            ->and($toast->getTitle())->toEqual(match ($type) {
                'success' => _('Success'),
                'danger' => _('Error'),
                'warning' => _('Warning'),
                'info' => _('Notice'),
            })
            ->and($toast->getIcon())->toEqual(match ($type) {
                'success' => 'check',
                'danger' => 'exclamation-circle',
                'warning' => 'exclamation-triangle',
                'info' => 'info-circle',
            });

    }
});

test('links can be added', function () {
    $toast = new Toast('Some message');

    $toast->link('Some label', 'link');
    $toast->link('Another label', 'link-2');

    expect($toast->hasLinks())->toBeTrue()
        ->and($toast->getLinks())->toHaveCount(2);
});
