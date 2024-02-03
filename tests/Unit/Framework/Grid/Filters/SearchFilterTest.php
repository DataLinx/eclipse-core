<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Filters\SearchFilter;
use Eclipse\Core\Models\User;
use Illuminate\Database\Eloquent\Builder;

uses(PackageTestCase::class);

test('can be created', function () {
    $filter = new SearchFilter(User::class);

    expect($filter->getName())->toEqual('search')
        ->and($filter->getLabel())->toEqual('Search');
});

test('exact condition can be applied', function () {
    $search = 'test';

    $manual_query = User::query();
    $manual_query->where(function (Builder $builder) use ($search) {
        $builder->orWhere('name', '=', $search);
        $builder->orWhere('surname', '=', $search);
        $builder->orWhere('email', '=', $search);
    });

    $query = User::query();

    $filter = new SearchFilter(User::class);
    $filter->addExactCondition('name');
    $filter->addExactCondition(['surname', 'email']);
    $filter->apply($query, $search);

    expect($query->toSql())->toEqual($manual_query->toSql());

    // Test composite attribute
    // -----------------------------------
    $manual_query_2 = User::query();
    $manual_query_2->where(function (Builder $builder) use ($search) {
        $builder->orWhereRaw(User::getCompositeDefinition('full_name').' = ?', [$search]);
    });

    $query_2 = User::query();

    $filter_2 = new SearchFilter(User::class);
    $filter_2->addExactCondition('full_name');
    $filter_2->apply($query_2, $search);

    expect($query_2->toSql())->toEqual($manual_query_2->toSql());
});

test('partial condition can be applied', function () {
    $search = 'test';

    $manual_query = User::query();
    $manual_query->where(function (Builder $builder) use ($search) {
        $builder->orWhere('name', 'like', "%$search%");
        $builder->orWhere('surname', 'like', "%$search%");
        $builder->orWhere('email', 'like', "%$search%");
    });

    $query = User::query();

    $filter = new SearchFilter(User::class);
    $filter->addPartialCondition('name');
    $filter->addPartialCondition(['surname', 'email']);
    $filter->apply($query, $search);

    expect($query->toSql())->toEqual($manual_query->toSql());

    // Test composite attribute
    // -----------------------------------
    $manual_query_2 = User::query();
    $manual_query_2->where(function (Builder $builder) use ($search) {
        $builder->orWhereRaw(User::getCompositeDefinition('full_name').' LIKE ?', ["%$search%"]);
    });

    $query_2 = User::query();

    $filter_2 = new SearchFilter(User::class);
    $filter_2->addPartialCondition('full_name');
    $filter_2->apply($query_2, $search);

    expect($query_2->toSql())->toEqual($manual_query_2->toSql());
});
