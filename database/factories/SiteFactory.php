<?php

namespace Eclipse\Core\Database\Factories;

use Eclipse\Core\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Eclipse\Core\Models\Site>
 */
class SiteFactory extends Factory
{
    protected $model = Site::class;

    /**
     * {@inheritDoc}
     */
    public function definition()
    {
        return [
            'domain' => fake()->domainName(),
            'name' => fake()->company(),
            'is_active' => 1,
            'is_main' => 0,
            'is_secure' => 1,
        ];
    }
}
