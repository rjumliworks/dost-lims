<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsrSampleReportSignatory extends Model
{
    protected $fillable = [
        'analyzed_timestamp',
        'analyzed_by',
        'analyzed_date',
        'certified_timestamp',
        'certified_by',
        'certified_date',
        'approved_timestamp',
        'approved_by',
        'approved_date',
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
}
