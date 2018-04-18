<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sentinel;

class InitialAdminAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initial:admin_account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Admin Account. Email/Pass config in .env. If not, default admin@admin.com - 123456';

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
        $email = env("ADMIN_ACCOUNT_EMAIL", "admin@admin.com");  
        $password = env("ADMIN_ACCOUNT_PASSWORD", "123456");
        $first_name = env("ADMIN_ACCOUNT_FIRST_NAME", "Admin");
        $last_name = env("ADMIN_ACCOUNT_LAST_NAME", "VN Tech");
        #--> Create User
        $user = Sentinel::registerAndActivate(array(
            'email'    => $email,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name
        ));
        #--> Add user to admin role
        $admin_role_id = 1;
        $role = Sentinel::findRoleById($admin_role_id);
        $role->users()->attach($user);
    }
}
