<?php
namespace App\Providers;

use App\Interfaces\BillRepositoryInterface;
use App\Repositories\CustomerRepository;
use App\Interfaces\CustomerRepositoryInterface;
use App\Repositories\BillRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(BillRepositoryInterface::class, BillRepository::class);
    }
}