<?php

namespace Eclipse\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Eclipse\Core\Models\AppInstance;
use Eclipse\Core\Models\Package;
use Eclipse\Core\Models\Site;
use Eclipse\Core\Models\User;

class EclipseInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eclipse:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Eclipse installation procedure';

    /**
     * Default answers, used for testing
     *
     * @var array
     */
    protected array $defaults = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info("Running Eclipse installation procedure...");

        $this->callSilent('migrate:fresh');

        $this->callSilent('eclipse:discover-packages');

        $this->callSilent('eclipse:map-config');

        // Are we in testing?
        if (App::environment('testing') and $this->option('no-interaction')) {
            // Set defaults when there's no interaction
            $this->defaults = [
                'site' => [
                    'domain' => 'eclipse.local',
                    'name' => 'Eclipse Test',
                ],
                'user' => [
                    'name' => 'John',
                    'surname' => 'Doe',
                    'email' => 'john@datalinx.si',
                    'password' => 'test123',
                ],
            ];
        }

        // Create main site
        $site = $this->createSite();

        // Create admin user
        $this->createUser();

        // Done
        $this->newLine(2);
        $this->info(sprintf('All done! You can now login at %s', $site->getUrl()));
        $this->newLine(2);
    }

    /**
     * Create main site
     *
     * @return Site
     */
    private function createSite(): Site
    {
        $this->newLine(2);
        $this->question("Please provide the default site data.");

        $site = new Site();
        $site->is_main = 1;

        // Domain
        do {
            $site->domain = $this->ask('Enter the project domain name', $this->defaults['site']['domain'] ?? null);
        } while (empty($site->domain));

        // Site name
        do {
            $site->name = $this->ask('Enter the project name',$this->defaults['site']['name'] ?? null);
        } while (empty($site->name));

        $site->is_secure = $this->confirm('Is this site served over HTTPS?');

        $site->save();

        // Create default instance
        $core_package = Package::fetchByName('eclipse', 'core');

        $instance = new AppInstance;
        $instance->site_id = $site->id;
        $instance->app_package_id = $core_package->id;
        $instance->path = '/';
        $instance->save();

        $instance_lang = new AppInstance\Language();
        $instance_lang->app_instance_id = $instance->id;
        $instance_lang->language_id = 'en';
        $instance_lang->is_default = true;
        $instance_lang->save();

        // Done
        $this->info("✓ Created site $site->domain");

        return $site;
    }

    /**
     * Create Admin user
     *
     * @return void
     */
    private function createUser(): void
    {
        $this->newLine(2);
        $this->question("Please provide your user data for the admin account.");

        $admin = new User();

        // Name
        do {
            $admin->name = $this->ask('First name', $this->defaults['user']['name'] ?? null);
        } while (empty($admin->name));

        // Surname
        do {
            $admin->surname = $this->ask('Last name', $this->defaults['user']['surname'] ?? null);
        } while (empty($admin->surname));

        // Email
        do {
            $admin->email = $this->ask('E-mail address', $this->defaults['user']['email'] ?? null);

            $validator = Validator::make([
                'email' => $admin->email,
            ], [
                'email' => ['required', 'email'],
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->get('email') as $message) {
                    $this->error($message);
                }
            }

        } while ($validator->fails());

        // Password
        do {
            if (isset($this->defaults['user']['password'])) {
                // In testing, we cannot use the secret() method, so we have to ask()
                $password = $this->ask('Please provide a password', $this->defaults['user']['password']);
                $password_conf = $this->ask('Repeat the password', $this->defaults['user']['password']);
            } else {
                $password = $this->secret('Please provide a password');
                $password_conf = $this->secret('Repeat the password');
            }

            $validator = Validator::make([
                'password' => $password,
                'password_confirmation' => $password_conf,
            ], [
                'password' => ['required', 'confirmed'],
            ]);

            if ($validator->fails()) {
                foreach ($validator->errors()->get('password') as $message) {
                    $this->error($message);
                }
            }

        } while ($validator->fails());

        $admin->password = Hash::make($password);

        // Done, save
        $admin->save();

        $this->info("✓ Created user $admin->email");
    }
}
