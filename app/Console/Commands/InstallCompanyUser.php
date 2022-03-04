<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallCompanyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install default company user';

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
        if($this->confirm('Do you want to create company user? (yes|no)[yes]', true)) {
            Artisan::call('migrate');
            if (User::where('email', 'company@gmail.com')->exists()) {
                $this->info('User is already created! emial: company@gmail.com, password: company123');
            } else {
                User::firstOrCreate([
                    'name'          => 'Admin',
                    'email'         => "company@gmail.com",
                    'password'      => bcrypt('company123'),
                    'role'          => 'company'
                ]);
                $this->info('User is created! emial: company@gmail.com, password: company123');
            }
        } else {
            $this->info('Installation canceled!');
        }

        
    }
}
