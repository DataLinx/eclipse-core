<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Action;
use Eclipse\Core\Models\User;

uses(PackageTestCase::class);

test('can be created', function () {
    $user = User::factory()->create();
    $url = url("/users/$user->id/edit");

    $action = new Action('edit', $url, 'Edit user');

    expect($action->getCode())->toEqual('edit')
        ->and($action->hasUrl())->toBeTrue()
        ->and($action->getUrl($user))->toEqual($url)
        ->and($action->getLabel())->toEqual('Edit user');

    // Test default labels
    $edit_action = new Action('edit');
    expect($edit_action->hasUrl())->toBeFalse()
        ->and($edit_action->getLabel())->toEqual('Edit');

    $delete_action = new Action('delete');
    expect($delete_action->getLabel())->toEqual('Delete');

    $view_action = new Action('view');
    expect($view_action->getLabel())->toEqual('View');

    $other_action = new Action('other');
    expect($other_action->getLabel())->toEqual('Other');
});
