<?php

namespace App\Models;

use App\Enums\BillHistoricStatusEnum;
use App\Enums\BillHistoricTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $customer_id Customer ID
 * @property double $amount Amount
 * @property integer $due_date Due date
 * @property string $description Description
*/
class Bill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id', 
        'amount', 
        'due_date', 
        'description', 
    ];
    
    public function createHistoric(string $payload, BillHistoricTypeEnum $type = BillHistoricTypeEnum::Mailing, BillHistoricStatusEnum $status = BillHistoricStatusEnum::Done)
    {
        $this->historic()->create([
            "payload" => $payload,
            "type" => $type,
            "status" => $status
        ]);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
        
    public function historic(): HasMany
    {
        return $this->hasMany(BillHistoric::class);
    }

}
