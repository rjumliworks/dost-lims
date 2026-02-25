<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationReferral extends Model
{
    protected $fillable = [
        'is_psto', 'province_code', 'agency_id', 'tsr_id'
    ];

    public function quotation()
    {
        return $this->belongsTo('App\Models\Quotation', 'quotation_id', 'id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\LocationProvince', 'province_code', 'code');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }
}
