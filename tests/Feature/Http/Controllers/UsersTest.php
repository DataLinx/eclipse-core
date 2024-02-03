<?php

use Eclipse\Core\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->authedUser = User::factory()->make();
});

test('unauthorized access can be prevented', function () {
    $this->get('users')
        ->assertRedirect('login');
});

test('authorized access can be allowed', function () {
    $this->actingAs($this->authedUser)
        ->get('users')
        ->assertOk();
});

test('create user screen can be rendered', function () {
    $this->actingAs($this->authedUser)
        ->get('users/create')
        ->assertOk();
});

test('creation can be canceled', function () {
    $this->actingAs($this->authedUser)
        ->post('users', [
            'action' => 'cancel',
        ])
        ->assertRedirect('users');
});

test('new user can be created', function () {
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
    expect($user)->toBeObject();

    foreach ($data as $key => $val) {
        if ($key === 'password') {
            expect(Hash::check($val, $user->password))->toBeTrue('Hashed password differs from plain-text!');
        } else {
            expect($user->$key)->toEqual($val);
        }
    }

    expect($user->full_name)->toEqual('John Doe');
});

test('edit user screen can be rendered', function () {
    $user = User::factory()->create();

    $this->actingAs($this->authedUser)
        ->get('users/'.$user->id.'/edit')
        ->assertOk();
});

test('edit can be canceled', function () {
    $user = User::factory()->create();

    $this->actingAs($this->authedUser)
        ->put('users/'.$user->id, [
            'action' => 'cancel',
        ])
        ->assertRedirect('users');
});

test('existing user can be updated', function () {
    $this->actingAs($this->authedUser);

    $user = User::factory()->create();

    $data = [
        'name' => 'Diego',
        'surname' => 'de la Vega',
        'email' => 'diego@vega.es',
    ];

    $response = $this->put('users/'.$user->id, $data);

    $response->assertRedirect('users');

    $updatedUser = User::fetchByEmail('diego@vega.es');
    expect($updatedUser)->toBeObject();

    foreach ($data as $key => $val) {
        expect($updatedUser->$key)->toEqual($val);
    }

    expect($updatedUser->password)->toEqual($user->password);
});

test('user can be deleted', function () {
    $this->actingAs($this->authedUser);

    $user = User::factory()->create();

    $response = $this->deleteJson('users/'.$user->id);

    $response->assertOk()
        ->assertJsonFragment(['error' => 0]);

    expect(DB::table('core_user')->where('id', $user->id)->doesntExist())->toBeTrue('User was not deleted!');
});
