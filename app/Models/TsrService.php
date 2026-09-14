<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TsrService extends Model
{
    use LogsActivity;

    protected $fillable = [
        'fee',
        'total',
        'quantity',
        'service_id',
        'is_additional'
    ];

    public function typeable()
    {
        return $this->morphTo();
    }
    
    public function service()
    {
        return $this->belongsTo('App\Models\TestserviceAddon', 'service_id', 'id');
    }

    public function setFeeAttribute($value)
    {
        $this->attributes['fee'] = trim(str_replace(',','',$value),'₱');
    }

    public function getFeeAttribute($value)
    {
        return '₱'.$value;
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = trim(str_replace(',','',$value),'₱');
    }

    public function getTotalAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['fee', 'total', 'quantity', 'service_id', 'is_additional'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Service')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
