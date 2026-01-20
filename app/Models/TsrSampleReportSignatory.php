<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsrSampleReportSignatory extends Model
{
    protected $fillable = [
        'timestamp',
        'user_id',
        'report_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function report()
    {
        return $this->belongsTo('App\Models\TsrSampleReport', 'report_id', 'id');
    }
}
