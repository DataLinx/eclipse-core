<?php declare(strict_types=1);

namespace Eclipse\Core\Tests\Unit\Framework\Grid\Columns;

use InvalidArgumentException;
use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Action;
use Eclipse\Core\Framework\Grid\Columns\ActionColumn;
use Eclipse\Core\Models\User;

class ActionColumnTest extends PackageTestCase
{
    public function test_can_be_created(): void
    {
        $column = new ActionColumn([
            new Action('edit', url("/users/{id}/edit")),
            new Action('delete'),
        ]);

        $user = User::factory()->create();

        // Test actions
        $actions = [
            '<a class="btn btn-secondary btn-sm grid-action" data-action="edit" href="'. str_replace('{id}', (string)$user->id, url("/users/{id}/edit")) .'">Edit</a>',
            '<a class="btn btn-secondary btn-sm grid-action" data-action="delete" href="javascript:void(0);">Delete</a>',
        ];

        $this->assertEquals(implode(' ', $actions), $column->render($user));

        // Test sortable parameter
        $this->assertFalse($column->sortable);

        $this->expectException(InvalidArgumentException::class);
        $column->setSortable(true);
    }
}