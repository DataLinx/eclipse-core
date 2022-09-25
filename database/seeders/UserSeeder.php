<?php

namespace SDLX\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use SDLX\Core\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(100)->create();
    }
}
