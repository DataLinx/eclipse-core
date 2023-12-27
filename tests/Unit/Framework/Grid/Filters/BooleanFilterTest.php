<?php declare(strict_types=1);

namespace Tests\Unit\Framework\Grid\Filters;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Filters\BooleanFilter;
use Eclipse\Core\Models\User;

class BooleanFilterTest extends PackageTestCase
{
    public function test_can_be_created(): void
    {
        $filter = new BooleanFilter('test', 'Test filter');

        $this->assertEquals('test', $filter->getName());
        $this->assertEquals('Test filter', $filter->getLabel());
        $this->assertEquals('active_filters.test', $filter->getModelName());
    }

    public function test_can_be_applied(): void
    {
        $filter = new BooleanFilter('test', 'Test filter');

        $query = User::query();
        $this->assertStringNotContainsString('test IS NOT NULL', $query->toSql());

        $filter->apply($query, true);
        $this->assertStringContainsStringIgnoringCase('"test" IS NOT NULL', $query->toSql());
    }
}
