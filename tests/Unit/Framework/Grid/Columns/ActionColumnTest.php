<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Action;
use Eclipse\Core\Framework\Grid\Columns\ActionColumn;
use Eclipse\Core\Models\User;

uses(PackageTestCase::class);

test('can be created', function () {
    $column = new ActionColumn([
        new Action('edit', url('/users/{id}/edit')),
        new Action('delete'),
    ]);

    $user = User::factory()->create();

    // Test actions
    $actions = [
        '<a class="btn btn-secondary btn-sm grid-action" data-action="edit" href="'.str_replace('{id}', (string) $user->id, url('/users/{id}/edit')).'">Edit</a>',
        '<a class="btn btn-secondary btn-sm grid-action" data-action="delete" href="javascript:void(0);">Delete</a>',
    ];

    expect($column->render($user))->toEqual(implode(' ', $actions))
        ->and($column->sortable)->toBeFalse();

    // Test sortable parameter

    $this->expectException(InvalidArgumentException::class);
    $column->setSortable(true);
});
