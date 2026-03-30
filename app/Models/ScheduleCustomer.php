<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleCustomer extends Model
{
    protected $fillable = [
        'samples',
        'tsr_id',
        'customer_id',
        'conforme_id',
        'schedule_id'
    ];

    public function tsr(){ return $this->belongsTo('App\Models\Tsr', 'tsr_id', 'id');}
    public function customer(){ return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');}
    public function conforme(){ return $this->belongsTo('App\Models\CustomerConforme', 'conforme_id', 'id');}
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
