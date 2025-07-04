<?php

namespace App\Services;

use App\Enums\BillHistoricStatusEnum;
use App\Enums\BillHistoricTypeEnum;
use App\Models\Bill;
use App\Models\Customer;
use App\Notifications\BillNotification;
use Illuminate\Support\Carbon;

class CustomerService
{
    public function totalInMonth(Customer $customer, string $month): float
    {
        //Concat the input YYYY-mm with -01 to create a full date string.
        $start = Carbon::parse($month . '-01')->startOfMonth();
        $end = $start->copy()->endOfMonth();

        return $customer->bills()
            ->whereBetween('due_date', [$start, $end])
            ->sum('amount');
    }
}