<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsrSampleReportList extends Model
{
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
}
