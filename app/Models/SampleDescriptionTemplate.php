<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SampleDescriptionTemplate extends Model
{
    protected $fillable = [
        'agency_id', 'sampletype_id', 'name', 'customer_description', 'description', 'created_by'
    ];

    public function sampletype()
    {
        return $this->belongsTo('App\Models\SampleType', 'sampletype_id', 'id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
}
