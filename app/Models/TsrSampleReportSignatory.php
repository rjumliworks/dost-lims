<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TsrSampleReportSignatory extends Model
{
    use LogsActivity;

    protected $fillable = [
        // 'analyzed_timestamp',
        'analyzed_by',
        'analyzed_date',
        // 'certified_timestamp',
        'certified_by',
        'certified_date',
        // 'approved_timestamp',
        'approved_by',
        'approved_date',
        'status_id',
        'report_id'
    ];

    public function analyzed()
    {
        return $this->belongsTo('App\Models\User', 'analyzed_by', 'id');
    }

    public function certified()
    {
        return $this->belongsTo('App\Models\User', 'certified_by', 'id');
    }

    public function approved()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function report()
    {
        return $this->belongsTo('App\Models\TsrSampleReport', 'report_id', 'id');
    }

    public function status(){ return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');}

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['analyzed_by', 'analyzed_date', 'certified_by', 'certified_date', 'approved_by', 'approved_date', 'status_id', 'report_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Sample Report Signatory')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
