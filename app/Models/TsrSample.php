<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;

class TsrSample extends Model
{
    protected $fillable = [
        'code',
        'name',
        'customer_description',
        'description',
        'is_disposed',
        'is_completed',
        'samplename_id',
        'sampletype_id',
        'tsr_id',
        'completed_at'
    ];

    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
    }

    public function tsr()
    {
        return $this->belongsTo('App\Models\Tsr', 'tsr_id', 'id');
    }

    public function sample()
    {
        return $this->belongsTo('App\Models\ListName', 'sampletype_id', 'id');
    }

    public function report()
    {
        return $this->hasOne('App\Models\TsrSampleReport', 'sample_id');
    }

    public function reportlist()
    {
        return $this->hasOne('App\Models\TsrSampleReportList', 'sample_id');
    }

    public function disposal()
    {
        return $this->hasOne('App\Models\TsrSampleDisposal', 'sample_id');
    }

    public function analyses()
    {
        return $this->hasMany('App\Models\TsrAnalysis', 'sample_id');
    }
    
    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCompletedAtAttribute($value)
    {

        return ($value) ? date('F d, Y', strtotime($value)) : null;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
    }
}
