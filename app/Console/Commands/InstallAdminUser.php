<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install default admin user';

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
        if($this->confirm('Do you want to create admin user? (yes|no)[yes]', true)) {
            Artisan::call('migrate');
            if (User::where('email', 'admin@gmail.com')->exists()) {
                $this->info('User is already created! emial: admin@gmail.com, password: admin123');
            } else {
                User::firstOrCreate([
                    'name'          => 'Admin',
                    'email'         => "admin@gmail.com",
                    'password'      => bcrypt('admin123'),
                    'role'          => 'admin'
                ]);
                $this->info('User is created! emial: admin@gmail.com, password: admin123');
            }
        } else {
            $this->info('Installation canceled!');
        }

        
    }
}
