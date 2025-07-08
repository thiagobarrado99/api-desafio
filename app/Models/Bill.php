<?php

namespace App\Models;

use App\Enums\BillHistoricStatusEnum;
use App\Enums\BillHistoricTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * 
 *
 * @property integer $customer_id Customer ID
 * @property double $amount Amount
 * @property integer $due_date Due date
 * @property string $description Description
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BillHistoric> $historic
 * @property-read int|null $historic_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Bill whereUpdatedAt($value)
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Bill extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id', 
        'amount', 
        'due_date', 
        'description', 
    ];
    
    public function createHistoric(string $payload, BillHistoricTypeEnum $type = BillHistoricTypeEnum::Mailing, BillHistoricStatusEnum $status = BillHistoricStatusEnum::Done): void
    {
        $this->historic()->create([
            "payload" => $payload,
            "type" => $type,
            "status" => $status
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Customer, $this>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
       
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\BillHistoric, $this>
     */
    public function historic(): HasMany
    {
        return $this->hasMany(BillHistoric::class);
    }

}
