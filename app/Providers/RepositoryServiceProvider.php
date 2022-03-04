<?php

namespace App\Providers;

use App\Repositories\Api\CompanyRepository;
use App\Repositories\Api\EmployeeRepository;
use App\Repositories\Api\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Api\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Api Repositories
         */
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
