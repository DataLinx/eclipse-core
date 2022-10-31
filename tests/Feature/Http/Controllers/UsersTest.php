<?php

namespace SDLX\Core\Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use SDLX\Core\Foundation\Testing\PackageTestCase;
use SDLX\Core\Models\User;

class UsersTest extends PackageTestCase
{
    protected $authedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authedUser = User::factory()->make();
    }

    public function test_unauthorized_access_can_be_prevented()
    {
        $this->get('users')
             ->assertRedirect('login');
    }

    public function test_authorized_access_can_be_allowed()
    {
        $this->actingAs($this->authedUser)
             ->get('users')
             ->assertOk()
             ->assertViewIs('core::users.index');
    }

    public function test_create_user_screen_can_be_rendered()
    {
        $this->actingAs($this->authedUser)
             ->get('users/create')
             ->assertOk()
             ->assertViewIs('core::users.edit');
    }

    public function test_creation_can_be_canceled()
    {
        $this->actingAs($this->authedUser)
             ->post('users', [
                 'action' => 'cancel',
             ])
             ->assertRedirect('users');
    }

    public function test_new_user_can_be_created()
    {
        $this->actingAs($this->authedUser);

        $data = [
            'name' => 'John',
            'surname' => 'Doe',
            'email' => 'john@doe.net',
            'password' => 'johndoe',
        ];

        $response = $this->post('users', $data);

        $response->assertRedirect('users');

        $user = User::fetchByEmail('john@doe.net');
        $this->assertIsObject($user);

        foreach ($data as $key => $val) {
            if ($key === 'password') {
                $this->assertTrue(Hash::check($val, $user->password), 'Hashed password differs from plain-text!');
            } else {
                $this->assertEquals($val, $user->$key);
            }
        }

        $this->assertEquals('John Doe', $user->full_name);
    }

    public function test_edit_user_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($this->authedUser)
             ->get('users/'. $user->id .'/edit')
             ->assertOk()
             ->assertViewIs('core::users.edit');
    }

    public function test_edit_can_be_canceled()
    {
        $user = User::factory()->create();

        $this->actingAs($this->authedUser)
             ->put('users/'. $user->id,  [
                 'action' => 'cancel',
             ])
             ->assertRedirect('users');
    }

    public function test_existing_user_can_be_updated()
    {
        $this->actingAs($this->authedUser);

        $user = User::factory()->create();

        $data = [
            'name' => 'Diego',
            'surname' => 'de la Vega',
            'email' => 'diego@vega.es',
        ];

        $response = $this->put('users/'. $user->id, $data);

        $response->assertRedirect('users');

        $updatedUser = User::fetchByEmail('diego@vega.es');
        $this->assertIsObject($updatedUser);

        foreach ($data as $key => $val) {
            $this->assertEquals($val, $updatedUser->$key);
        }

        $this->assertEquals($user->password, $updatedUser->password);
    }

    public function test_user_can_be_deleted()
    {
        $this->actingAs($this->authedUser);

        $user = User::factory()->create();

        $response = $this->deleteJson('users/'. $user->id);

        $response->assertOk()
                 ->assertJsonFragment(['error' => 0]);

        $this->assertTrue(DB::table('core_user')->where('id', $user->id)->doesntExist(), 'User was not deleted!');
    }
}
