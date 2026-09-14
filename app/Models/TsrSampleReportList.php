<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TsrSampleReportList extends Model
{
    use LogsActivity;

    protected $fillable = [
        'sample_id',
        'report_id'
    ];

    public function sample()
    {
        return $this->belongsTo('App\Models\TsrSample', 'sample_id', 'id');
    }

    public function report()
    {
        return $this->belongsTo('App\Models\TsrSampleReport', 'report_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['sample_id', 'report_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Sample Report List')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
