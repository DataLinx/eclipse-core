<?php

namespace Eclipse\Core\Console\Commands;

use Eclipse\Core\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DiscoverPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eclipse:discover-packages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Discover Eclipse packages from vendors';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dir = base_path('vendor');

        $this->info("Discovering Eclipse packages in $dir");

        foreach (File::directories($dir) as $vendor_dir) {
            foreach (File::directories($vendor_dir) as $package_dir) {

                if (! file_exists($package_dir.'/composer.json')) {
                    continue;
                }

                $json = json_decode(file_get_contents($package_dir.'/composer.json'), true);

                if (! isset($json['extra']['eclipse']['type'])) {
                    // Not an Eclipse package
                    continue;
                }

                $vendor = basename($vendor_dir);
                $name = basename($package_dir);
                $type = substr($json['extra']['eclipse']['type'], 0, 1);

                $package = Package::where([
                    'vendor' => $vendor,
                    'name' => $name,
                ])->first();

                if (empty($package)) {
                    $package = new Package;
                    $package->vendor = $vendor;
                    $package->name = $name;
                    $package->type = $type;
                    $package->save();
                    $this->line("Found new package: $vendor/$name");
                } elseif ($package->type !== $type) {
                    $package->type = $type;
                    $package->save();
                    $this->line("Updated package: $vendor/$name");
                }
            }
        }

        return 0;
    }
}
