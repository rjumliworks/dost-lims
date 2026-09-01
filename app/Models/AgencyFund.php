<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyFund extends Model
{
    protected $fillable = [
        'agency_id','source','code','is_active'
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }
}
