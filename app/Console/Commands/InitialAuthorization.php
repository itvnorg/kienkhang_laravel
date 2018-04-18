<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sentinel;

class InitialAuthorization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'initial:authorization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inital Roles';

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
        $roles_data = [
            ['id' => 1, 'name' => 'admin', 'slug' => 'admin']
        ];
        foreach ($roles_data as $role_item) {
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'id'   => $role_item['id'],
                'name' => $role_item['name'],
                'slug' => $role_item['slug']
            ]);
        }
    }
}
