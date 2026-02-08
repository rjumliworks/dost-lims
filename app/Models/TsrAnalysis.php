<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TsrAnalysis extends Model
{
    use LogsActivity;

    protected $fillable = [
        'status_id','sample_id','testservice_id','fee','started_by','ended_by','start_at','end_at'
    ];

    public function status(){ return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id'); }
    public function sample(){ return $this->belongsTo('App\Models\TsrSample', 'sample_id', 'id');}
    public function started(){ return $this->belongsTo('App\Models\User', 'started_by', 'id');}
    public function ended(){ return $this->belongsTo('App\Models\User', 'ended_by', 'id');}
    public function testservice(){ return $this->belongsTo('App\Models\Testservice', 'testservice_id', 'id');}

    public function addfee(){ return $this->morphMany('App\Models\TsrService', 'typeable');}  
    public function remarkable(){ return $this->morphOne('App\Models\TsrRemark', 'remarkable');} 

    public function getStartAtAttribute($value){ return ($value) ? date('M d, Y', strtotime($value)) : null;}
    public function getEndAtAttribute($value){ return ($value) ? date('M d, Y', strtotime($value)) : null;}
    public function getCreatedAtAttribute($value){ return date('M d, Y g:i a', strtotime($value));}
    public function getUpdatedAtAttribute($value){ return date('M d, Y g:i a', strtotime($value));}

    public function setFeeAttribute($value)
    {
        $this->attributes['fee'] = trim(str_replace(',','',$value),'₱');
    }

    public function getFeeAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly( [
          'status_id','started_by','ended_by','sample_id','testservice_id','fee','start_at','end_at'
        ])
        ->useLogName('Analysis')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
