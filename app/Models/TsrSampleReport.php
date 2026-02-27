<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;

class TsrSampleReport extends Model
{
    protected $fillable = [
        'code',
        'information',
        'passkey',
        'attachment',
        'sample_id',
        'user_id',
        'cro_id',
        'tm_id'
    ];

    protected $appends = ['reference'];
 
    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
    }

    public function sample()
    {
        return $this->belongsTo('App\Models\TsrSample', 'sample_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function cro()
    {
        return $this->belongsTo('App\Models\User', 'cro_id', 'id');
    }

    public function tm()
    {
        return $this->belongsTo('App\Models\User', 'tm_id', 'id');
    }

    public function lists()
    {
        return $this->hasMany('App\Models\TsrSampleReportList', 'report_id');
    }

    public function signatory()
    {
        return $this->hasOne('App\Models\TsrSampleReportSignatory', 'report_id');
    }

    public function setPasskeyAttribute($value)
    {
        $this->attributes['passkey'] = Crypt::encryptString($value);
    }

    public function getPasskeyAttribute($value)
    {
        return ($value) ? Crypt::decryptString($value) : null;
    }

    public function getCreatedAtAttribute($value)
    {
        return date('F d, Y g:i a', strtotime($value));
    }

    public function getCodeAttribute($value)
    {
        return Str::after($value, '-');
    }
}
