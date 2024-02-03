<?php

declare(strict_types=1);

use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Models\User;
use Eclipse\Core\View\Grids\Users;
use Livewire\Livewire;

uses(PackageTestCase::class);

beforeEach(function () {
    $this->authedUser = User::factory()->make();
});

test('component can be displayed', function () {
    $this->actingAs($this->authedUser)
        ->get('users')
        ->assertSeeLivewire('users-grid');
});

test('columns are set', function () {
    Livewire::test(Users::class)
        ->assertSeeInOrder([
            'ID',
            'Image',
            'Name',
            'Surname',
            'Full name',
            'Email address',
            'Email verified',
            'Action',
        ]);
});

test('sorting works', function () {
    /** @var User $user_1 */
    $user_1 = User::factory()->create();
    $user_1->name = 'Colin';
    $user_1->save();

    /** @var User $user_2 */
    $user_2 = User::factory()->create();
    $user_2->name = 'Abraham';
    $user_2->save();

    /** @var User $user_3 */
    $user_2 = User::factory()->create();
    $user_2->name = 'Boris';
    $user_2->save();

    Livewire::test(Users::class)
        ->assertSeeInOrder([
            'Colin',
            'Abraham',
            'Boris',
        ])
        ->call('sortBy', 'name')
        ->assertSeeInOrder([
            'Abraham',
            'Boris',
            'Colin',
        ])
        ->call('sortBy', 'name')
        ->assertSeeInOrder([
            'Colin',
            'Boris',
            'Abraham',
        ]);
});

test('pagination works', function () {
    /** @var User $user_first */
    $user_first = User::factory()->create();

    User::factory(99)->create();

    /** @var User $user_last */
    $user_last = User::factory()->create();

    Livewire::test(Users::class)
        ->assertSee($user_first->email)
        ->assertDontSee($user_last->email)
        ->set('per_page', 1000)
        ->assertSee($user_last->email)
        ->set('per_page', 50)
        ->assertDontSee($user_last->email)
        ->set('page', 3)
        ->assertSee($user_last->email);
});

test('boolean filter works', function () {
    /** @var User $user_1 */
    $user_1 = User::factory()->create();
    $user_1->email_verified_at = null;
    $user_1->save();

    /** @var User $user_2 */
    $user_2 = User::factory()->create();
    $user_2->email_verified_at = date('Y-m-d H:i:s');
    $user_2->save();

    Livewire::test(Users::class)
        ->assertSee($user_1->email)
        ->assertSee($user_2->email)
        ->set('active_filters.email_verified_at', 1)
        ->assertDontSee($user_1->email)
        ->assertSee($user_2->email);
});

test('search filter works', function () {
    /** @var User $user_1 */
    $user_1 = User::factory()->create();

    /** @var User $user_2 */
    $user_2 = User::factory()->create();

    Livewire::test(Users::class)
        ->assertSee($user_1->email)
        ->assertSee($user_2->email)
        ->set('active_filters.search', $user_1->email)
        ->assertSee($user_1->email)
        ->assertDontSee($user_2->email);
});
