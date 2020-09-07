<?php

namespace Ocelot\Core\Tests\Feature;

use Ocelot\Core\Models\User;
use Ocelot\Core\Tests\PackageTestCase;

class UserTest extends PackageTestCase
{
    /**
     * Test access
     *
     * @return void
     */
    public function testUnauthorizedAccess()
    {
        $response = $this->get('/users');

        $response->assertRedirect('login');
    }

    public function testAuthorizedAccess()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/users');

        $response->assertOk();
    }
}