<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TsrSampleDisposal extends Model
{
    use LogsActivity;

    protected $fillable = [
        'disposed_at',
        'disposal_id',
        'sample_id',
        'user_id',
        'status_id'
    ];

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function disposal()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'disposal_id', 'id');
    }

    public function sample()
    {
        return $this->belongsTo('App\Models\TsrSample', 'sample_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function getDisposedAtAttribute($value)
    {
        return ($value) ? date('M d, Y', strtotime($value)) : null;
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['disposed_at', 'disposal_id', 'sample_id', 'user_id', 'status_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Sample Disposal')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
