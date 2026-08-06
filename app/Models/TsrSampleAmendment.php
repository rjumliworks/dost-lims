<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsrSampleAmendment extends Model
{
    protected $fillable = [
        'sample_id',
        'previous_description',
        'proposed_description',
        'previous_customer_description',
        'proposed_customer_description',
        'remarks',
        'review_remarks',
        'requested_by',
        'reviewed_by',
        'reviewed_at',
        'status_id',
    ];

    public function sample()
    {
        return $this->belongsTo('App\Models\TsrSample', 'sample_id', 'id');
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

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getReviewedAtAttribute($value)
    {
        return ($value) ? date('M d, Y g:i a', strtotime($value)) : null;
    }
}
