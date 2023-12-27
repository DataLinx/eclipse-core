<?php

namespace Eclipse\Core\Models;

use Eclipse\Core\Database\Factories\SiteFactory;
use Eclipse\Core\Foundation\Database\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Site
 *
 * @property int $id Site ID
 * @property string $domain Domain
 * @property string $name Name
 * @property int $is_active Is active 0/1
 * @property int $is_main Is main site 0/1
 * @property int $is_secure Is secure site 0/1
 */
class Site extends Model
{
    use HasFactory;

    protected $table = 'core_site';

    protected $attributes = [
        'is_active' => 1,
        'is_main' => 0,
    ];

    /**
     * Get full URL to site
     */
    public function getUrl(): string
    {
        return ($this->is_secure ? 'https' : 'http').'://'.$this->domain;
    }

    /**
     * Get main site
     *
     * @return static
     */
    public static function fetchMainSite(): self
    {
        return self::where('is_main', 1)->firstOrFail();
    }

    /**
     * {@inheritDoc}
     */
    protected static function newFactory()
    {
        return SiteFactory::new();
    }
}
