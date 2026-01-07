<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyDiscount extends Model
{
    protected $fillable = [
        'agency_id','discount_id','is_occasional','is_active'
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo('App\Models\ListDiscount', 'discount_id', 'id');
    }
}
