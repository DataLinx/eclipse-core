<?php

namespace Ocelot\Core\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Ocelot\Core\Database\Mapper;
use Ocelot\Core\Foundation\AbstractConfig;
use Ocelot\Core\Models\Package;
use Ocelot\Core\Models\Site;

class MapConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ocelot:map-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Map config files to database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Mapping configs...");

        $mapper = new Mapper();

        // Load all package configs
        foreach (Package::all() as $package) {
            $this->loadPackageConfigs($package);
        }

        // Get all classes that extend the AbstractConfig class
        $processed = [];
        foreach (get_declared_classes() as $class) {
            if ($class !== AbstractConfig::class and is_a($class, AbstractConfig::class, true)) {
                try {
                    $mapper->map($class);
                    $this->assert_site_config($class);
                    $processed[] = $class;
                } catch (Exception $exception) {
                    $this->error(sprintf("Exception thrown when mapping columns for %s: %s", $class, $exception->getMessage()));
                }
            }
        }

        // After all is done, remove deprecated columns
        foreach ($processed as $class) {
            try {
                $mapper->removeDeprecatedColumns($class);
            } catch (Exception $exception) {
                $this->error(sprintf("Exception thrown when removing deprecated columns for %s: %s", $class, $exception->getMessage()));
            }
        }

        return 0;
    }

    /**
     * Find and load any Config classes in the package directory
     *
     * @param Package $package
     */
    private function loadPackageConfigs(Package $package)
    {
        $dir = $package->getDirectory() .'src/Configuration/';
        $this->line('Checking dir: '. $dir);

        if (file_exists($dir)) {
            foreach (File::allFiles($dir) as $file) {
                require_once $file;
            }
        }
    }

    /**
     * Assert config exists for all sites
     *
     * @param string $class Config class
     */
    private function assert_site_config(string $class)
    {
        foreach (Site::all() as $site) {
            /* @var $class AbstractConfig */
            $config = $class::fetch($site->id);
            if (empty($config)) {
                $config = new $class;
                $config->site_id = $site->id;
                $config->save();
            }
        }
    }
}
