<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;

class InitAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Init admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@email.com',
            'password' => bcrypt(12345678)
        ]);

        $this->info('Admin user successfully created!');
    }
}
