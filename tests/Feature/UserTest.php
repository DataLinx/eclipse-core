<?php

namespace Ocelot\Core\Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ocelot\Core\Models\User;
use Ocelot\Core\Tests\PackageTestCase;

class UserTest extends PackageTestCase
{
    protected $authedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authedUser = factory(User::class)->create();
    }

    public function testUnauthorizedAccess()
    {
        $this->get('users')
             ->assertRedirect('login');
    }

    public function testAuthorizedAccess()
    {
        $this->actingAs($this->authedUser)
             ->get('users')
             ->assertOk()
             ->assertViewIs('core::users.index');
    }

    public function testCreate()
    {
        $this->actingAs($this->authedUser)
             ->get('users/create')
             ->assertOk()
             ->assertViewIs('core::users.edit');
    }

    public function testStoreCancel()
    {
        $this->actingAs($this->authedUser)
             ->post('users', [
                 'action' => 'cancel',
             ])
             ->assertRedirect('users');
    }

    public function testStoreSubmit()
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
    }

    public function testEdit()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->authedUser)
             ->get('users/'. $user->id .'/edit')
             ->assertOk()
             ->assertViewIs('core::users.edit');
    }

    public function testUpdateCancel()
    {
        $user = factory(User::class)->create();

        $this->actingAs($this->authedUser)
             ->put('users/'. $user->id,  [
                 'action' => 'cancel',
             ])
             ->assertRedirect('users');
    }

    public function testUpdateSubmit()
    {
        $this->actingAs($this->authedUser);

        $user = factory(User::class)->create();

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

    public function testDestroy()
    {
        $this->actingAs($this->authedUser);

        $user = factory(User::class)->create();

        $response = $this->deleteJson('users/'. $user->id);

        $response->assertOk()
                 ->assertJsonFragment(['error' => 0]);

        $this->assertTrue(DB::table('cr_user')->where('id', $user->id)->doesntExist(), 'User was not deleted!');
    }
}