<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TsrAmendment extends Model
{
    use LogsActivity;

    protected $fillable = [
        'tsr_id',
        'previous_due_at',
        'proposed_due_at',
        'remarks',
        'review_remarks',
        'requested_by',
        'reviewed_by',
        'reviewed_at',
        'status_id',
    ];

    public function tsr()
    {
        return $this->belongsTo('App\Models\Tsr', 'tsr_id', 'id');
    }

    public function requestedBy()
    {
        return $this->belongsTo('App\Models\User', 'requested_by', 'id');
    }

    public function reviewedBy()
    {
        return $this->belongsTo('App\Models\User', 'reviewed_by', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function getPreviousDueAtAttribute($value)
    {
        return ($value) ? date('F d, Y', strtotime($value)) : null;
    }

    public function getProposedDueAtAttribute($value)
    {
        return ($value) ? date('F d, Y', strtotime($value)) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getReviewedAtAttribute($value)
    {
        return ($value) ? date('M d, Y g:i a', strtotime($value)) : null;
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly([
            'previous_due_at','proposed_due_at','remarks','review_remarks','requested_by','reviewed_by','reviewed_at','status_id'
        ])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Due Date Amendment')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
