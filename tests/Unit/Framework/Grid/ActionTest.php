<?php declare(strict_types=1);

namespace Eclipse\Core\Tests\Unit\Framework\Grid;

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Framework\Grid\Action;
use Eclipse\Core\Models\User;

class ActionTest extends PackageTestCase
{
    public function test_can_be_created(): void
    {
        $user = User::factory()->create();
        $url = url("/users/$user->id/edit");

        $action = new Action('edit', $url, 'Edit user');

        $this->assertEquals('edit', $action->getCode());
        $this->assertTrue($action->hasUrl());
        $this->assertEquals($url, $action->getUrl($user));
        $this->assertEquals('Edit user', $action->getLabel());

        // Test default labels
        $edit_action = new Action('edit');
        $this->assertFalse($edit_action->hasUrl());
        $this->assertEquals('Edit', $edit_action->getLabel());

        $delete_action = new Action('delete');
        $this->assertEquals('Delete', $delete_action->getLabel());

        $view_action = new Action('view');
        $this->assertEquals('View', $view_action->getLabel());

        $other_action = new Action('other');
        $this->assertEquals('Other', $other_action->getLabel());
    }
}
