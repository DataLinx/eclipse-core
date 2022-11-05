<?php

namespace SDLX\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SDLX\Core\Models\Site;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\SDLX\Core\Models\Site>
 */
class SiteFactory extends Factory
{
    protected $model = Site::class;

    /**
     * @inheritDoc
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
