<?php
namespace Ocelot\Core\Models;

use Ocelot\Core\Database\Model;

/**
 * Class Package
 * @package Ocelot\Core\Models
 *
 * @property int $id Package ID
 * @property string $vendor Vendor name
 * @property string $name Package name
 * @property string $type Package type (see class constants)
 */
class Package extends Model
{
    const TYPE_APP = 'a';
    const TYPE_MODULE = 'm';

    protected $table = 'cr_package';

    /**
     * Get package directory
     *
     * @return string
     * @throws \Exception
     */
    public function getDirectory()
    {
        return app_base_path("vendor/{$this->vendor}/{$this->name}/");
    }

    /**
     * Fetch Package by vendor and name
     *
     * @param string $vendor Vendor name
     * @param string $name Package name
     * @return \Illuminate\Database\Eloquent\Model|Package
     */
    public static function fetchByName($vendor, $name)
    {
        return self::where([
            'vendor' => $vendor,
            'name' => $name,
        ])->firstOrFail();
    }
}
