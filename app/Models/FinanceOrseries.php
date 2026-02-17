<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FinanceOrseries extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'start',
        'end',
        'next',
        'user_id',
        'is_active',
        'is_finished',
        'agency_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
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
        ->logOnly(['name',
        'start',
        'end',
        'next',
        'user_id',
        'is_active',
        'laboratory_id'])
        ->useLogName('ORSeries')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
