<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TsrRemark extends Model
{
    use LogsActivity;

    protected $fillable = [
        'amount',
        'reason',
        'type_id',
        'user_id'
    ];

    public function remarkable()
    {
        return $this->morphTo();
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = trim(str_replace(',','',$value),'₱');
    }

    public function getAmountAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['amount', 'reason', 'type_id', 'user_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Remark')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
