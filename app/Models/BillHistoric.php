<?php

namespace App\Models;

use App\Enums\BillHistoricStatusEnum;
use App\Enums\BillHistoricTypeEnum;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property BillHistoricTypeEnum $type Type
 * @property BillHistoricStatusEnum $status Status
 * @property string $payload Payload
 * @property int $id
 * @property int $bill_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BillHistoric whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Model
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
     * @var list<string>
     */
    protected $fillable = [
        'bill_id', 
        'type', 
        'status', 
        'payload', 
    ];
}
