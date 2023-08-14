<?php declare(strict_types=1);

namespace Eclipse\Core\Tests\Unit\Framework\Grid\Columns;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Columns\Column;
use Eclipse\Core\Models\Site;
use Eclipse\Core\Models\User;

class ColumnTest extends PackageTestCase
{
    public function test_can_be_created(): void
    {
        $column = new Column('test', 'Test label');

        $this->assertEquals('test', $column->getAccessor());
        $this->assertEquals('Test label', $column->getLabel());

        $column->setWidth(200);
        $this->assertEquals(200, $column->getWidth());

        $this->assertEquals(true, $column->isSortable());
        $column->setSortable(false);
        $this->assertEquals(false, $column->isSortable());
    }

    public function test_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $column = new Column('name', 'Name');

        $this->assertEquals($user->name, $column->render($user));

        $column_2 = new Column('url', 'URL');

        $site = Site::factory()->make();

        $this->assertEquals($site->getUrl(), $column_2->render($site));
    }
}
