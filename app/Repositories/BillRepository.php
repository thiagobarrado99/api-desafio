<?php
namespace App\Repositories;

use App\Interfaces\BillRepositoryInterface;
use App\Models\Bill;

class BillRepository extends BaseRepository implements BillRepositoryInterface
{
    public function __construct(Bill $model)
    {
        parent::__construct($model);
    }
}