<?php

namespace Ocelot\Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Ocelot\Core\User;

class OcelotInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ocelot:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the Ocelot installation procedure';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Running Ocelot installation procedure...");

        // Create admin user
        $this->createUser();
    }

    /**
     * Create Admin user
     */
    private function createUser()
    {
        $this->question("Please provide your user data for the admin account.");

        $admin = new User();

        // Name
        do {
            $admin->name = $this->ask('What is your name?');
        } while (empty($admin->name));

        // Surname
        do {
            $admin->surname = $this->ask('What is your surname?');
        } while (empty($admin->surname));

        // Email
        $validator = null;

        do {
            $admin->email = $this->ask('What is your e-mail address?');

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
            $password = $this->secret('Please provide a password:');
            $password_conf = $this->secret('Repeat the password:');

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

        $this->info('Created user '. $admin->email);
    }
}
