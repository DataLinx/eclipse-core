<?php

namespace Eclipse\Core\Console\Commands;

use Eclipse\Core\Models\Package;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DiscoverPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eclipse:discover-packages {--test : Run the command in test mode}';

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

        $js_files = [];
        $asset_dirs = [];

        if (App::environment(['local', 'testing'])) {

            // Get composer.json data for current package
            $data = json_decode(file_get_contents('./composer.json'), true);

            // If we are testing an Eclipse package...
            if (stripos($data['name'], 'eclipseapp/') === 0 and $data['name'] !== 'eclipseapp/skeleton') {

                $dir = getcwd() . '/vendor';

                // ... insert own package record, since discovery process below only scans the vendor folder
                [$vendor, $name] = explode('/', $data['name']);
                $type = substr($data['extra']['eclipse']['type'], 0, 1);

                $package = Package::where([
                    'vendor' => $vendor,
                    'name' => $name,
                ])->first();

                if (empty($package)) {
                    $package = new Package();
                    $package->vendor = $vendor;
                    $package->name = $name;
                    $package->type = substr($data['extra']['eclipse']['type'], 0, 1);
                } elseif ($package->type !== $type) {
                    $package->type = $type;
                }

                $package->save();

                if (file_exists("./resources/js/$name.js")) {
                    // Add with path relative to the App skeleton JS that is in ./vendor/eclipseapp/skeleton/resources/js
                    $js_files[] = "../../../../../resources/js/$name.js";
                }

                if (is_dir('./assets')) {
                    // Add path to module assets
                    $asset_dirs["$vendor/$name"] = '../../../../../../../assets';
                }
            }
        }

        if ($_ENV['ECLIPSE_PACKAGE_DEV'] ?? false) {
            // imports.js will be in vendor/eclipseapp/skeleton/storage/app
            $js_root = '../../../../';

            // Skeleton is in the vendor dir
            $asset_root = '../../../../../../';
        } else {
            // imports.js will be in storage/app
            $js_root = '../../vendor/';

            // Skeleton is in root
            $asset_root = '../../../../vendor/';
        }

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

                if (file_exists("$package_dir/resources/js/$name.js")) {
                    $js_files[] = $js_root."$vendor/$name/resources/js/$name.js";
                }

                if (is_dir("$package_dir/assets")) {
                    // Add path to module assets
                    $asset_dirs["$vendor/$name"] = $asset_root."$vendor/$name/assets";
                }
            }
        }

        // If not running unit tests or if we are testing this command...
        if (! App::runningUnitTests() || $this->option('test')) {

            // Write the JS imports file
            $this->write_js_imports($js_files);

            // Create asset symlinks
            $work_dir = getcwd();

            foreach ($asset_dirs as $pkg => $target) {
                // Make sure the target module dir exists
                $dir = base_path("public/modules/$pkg");

                if (! is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }

                chdir($dir);

                // Create symlink
                if (is_link('assets')) {
                    // Update if needed
                    $current = readlink('assets');
                    if ($current !== $target) {
                        unlink('assets');
                        symlink($target, 'assets');
                        $this->line("Updated assets symlink in $dir from $current to $target");
                    }
                } else {
                    // Create new link
                    symlink($target, 'assets');
                    $this->line("Created assets symlink in $dir to $target");
                }
            }

            chdir($work_dir);
        }

        return 0;
    }

    private function write_js_imports(array $files): void
    {
        $lines = [
            '// This file is auto-generated by the Eclipse DiscoverPackages class.',
            '// To update the file, run the eclipse:discover-packages command.',
            '',
        ];

        foreach ($files as $file) {
            $lines[] = "import '$file';";
        }

        $lines[] = '';

        $target_file = ($this->option('test') ? 'test-' : '').'imports.js';

        Storage::disk('local')->put($target_file, implode("\n", $lines));

        $this->line("Successfully updated the app JS imports file in $target_file");
    }
}
