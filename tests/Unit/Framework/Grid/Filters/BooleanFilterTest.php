<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Filters\BooleanFilter;
use Eclipse\Core\Models\User;

uses(PackageTestCase::class);

test('can be created', function () {
    $filter = new BooleanFilter('test', 'Test filter');

    expect($filter->getName())->toEqual('test')
        ->and($filter->getLabel())->toEqual('Test filter')
        ->and($filter->getModelName())->toEqual('active_filters.test');
});

test('can be applied', function () {
    $filter = new BooleanFilter('test', 'Test filter');

    $query = User::query();
    $this->assertStringNotContainsString('test IS NOT NULL', $query->toSql());

    $filter->apply($query, true);
    $this->assertStringContainsStringIgnoringCase('"test" IS NOT NULL', $query->toSql());
});
