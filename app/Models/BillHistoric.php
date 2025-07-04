<?php

namespace App\Models;

use App\Enums\BillHistoricStatusEnum;
use App\Enums\BillHistoricTypeEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * @property BillHistoricTypeEnum $type Type
 * @property BillHistoricStatusEnum $status Status
 * @property string $payload Payload
*/
class BillHistoric extends Model
{
    protected $casts = [
        'type' => BillHistoricTypeEnum::class,
        'status' => BillHistoricStatusEnum::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'bill_id', 
        'type', 
        'status', 
        'payload', 
    ];
}
