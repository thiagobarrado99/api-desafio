<?php
namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
}