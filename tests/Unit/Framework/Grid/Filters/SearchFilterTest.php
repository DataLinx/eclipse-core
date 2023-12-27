<?php

declare(strict_types=1);

namespace Tests\Unit\Framework\Grid\Filters;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Filters\SearchFilter;
use Eclipse\Core\Models\User;
use Illuminate\Database\Eloquent\Builder;

class SearchFilterTest extends PackageTestCase
{
    public function test_can_be_created(): void
    {
        $filter = new SearchFilter(User::class);

        $this->assertEquals('search', $filter->getName());
        $this->assertEquals('Search', $filter->getLabel());
    }

    public function test_exact_condition_can_be_applied(): void
    {
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

        $this->assertEquals($manual_query->toSql(), $query->toSql());

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

        $this->assertEquals($manual_query_2->toSql(), $query_2->toSql());
    }

    public function test_partial_condition_can_be_applied(): void
    {
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

        $this->assertEquals($manual_query->toSql(), $query->toSql());

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

        $this->assertEquals($manual_query_2->toSql(), $query_2->toSql());
    }
}
