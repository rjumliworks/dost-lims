<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerQuotationSampleAnalysis extends Model
{
      protected $fillable = [
        'sample_id','testservice_id','fee',
    ];

    public function sample()
    {
        return $this->belongsTo('App\Models\CustomerQuotationSample', 'sample_id', 'id');
    }

    public function testservice()
    {
        return $this->belongsTo('App\Models\Testservice', 'testservice_id', 'id');
    }

    public function setFeeAttribute($value)
    {
        $this->attributes['fee'] = trim(str_replace(',','',$value),'₱');
    }

    public function getFeeAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }
}
