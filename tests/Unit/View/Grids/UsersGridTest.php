<?php declare(strict_types=1);

namespace Tests\Unit\View\Grids;

use Livewire\Livewire;
use Eclipse\Core\Foundation\Testing\PackageTestCase;
use Eclipse\Core\Models\User;
use Eclipse\Core\View\Grids\Users;

class UsersGridTest extends PackageTestCase
{
    protected User $authedUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authedUser = User::factory()->make();
    }

    public function test_component_can_be_displayed(): void
    {
        $this->actingAs($this->authedUser)
            ->get('users')
            ->assertSeeLivewire('users-grid');
    }

    public function test_columns_are_set(): void
    {
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
    }

    public function test_sorting_works(): void
    {
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
    }

    public function test_pagination_works(): void
    {
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
    }

    public function test_boolean_filter_works(): void
    {
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
    }

    public function test_search_filter_works(): void
    {
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
    }
}
