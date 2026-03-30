<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleInformation extends Model
{
    protected $fillable = [
        'description',
        'venue',
        'schedule_id'
    ];

    public function schedule(){ return $this->belongsTo('App\Models\Schedule', 'schedule_id', 'id');}

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('F d, Y g:i a', strtotime($value));
    }
}
