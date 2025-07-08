<?php

namespace App\Services;

use App\Enums\BillHistoricStatusEnum;
use App\Enums\BillHistoricTypeEnum;
use App\Models\Bill;
use App\Models\Customer;
use App\Notifications\BillNotification;
use Illuminate\Support\Carbon;

class BillService
{
    public function createHistoric(Bill $bill, string $payload, BillHistoricTypeEnum $type = BillHistoricTypeEnum::Mailing, BillHistoricStatusEnum $status = BillHistoricStatusEnum::Done): void
    {
        $bill->historic()->create([
            "payload" => $payload,
            "type" => $type,
            "status" => $status
        ]);
    }

    public function notify(Bill $bill, BillNotification $notification): void
    {
        $bill->customer->notify($notification);
    }
}