<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Columns\Column;
use Eclipse\Core\Models\Site;
use Eclipse\Core\Models\User;

uses(PackageTestCase::class);

test('can be created', function () {
    $column = new Column('test', 'Test label');

    expect($column->getAccessor())->toEqual('test')
        ->and($column->getLabel())->toEqual('Test label');

    $column->setWidth(200);
    expect($column->getWidth())->toEqual(200)
        ->and($column->isSortable())->toEqual(true);

    $column->setSortable(false);
    expect($column->isSortable())->toEqual(false);
});

test('can be rendered', function () {
    $user = User::factory()->create();

    $column = new Column('name', 'Name');

    expect($column->render($user))->toEqual($user->name);

    $column_2 = new Column('url', 'URL');

    $site = Site::factory()->make();

    expect($column_2->render($site))->toEqual($site->getUrl());
});
