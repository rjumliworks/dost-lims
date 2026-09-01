<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListAccount extends Model
{
    protected $fillable = [
        'agency_id','name','code','account','is_active'
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }
}
