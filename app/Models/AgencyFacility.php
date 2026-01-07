<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyFacility extends Model
{
    protected $fillable = [
        'name','short','is_regional','is_psto','is_separated','address','longitude','latitude','barangay_code','municipality_code','province_code','region_code','agency_id'
    ];

    public function laboratories()
    {
        return $this->hasMany('App\Models\AgencyFacilityLaboratory', 'facility_id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('App\Models\LocationRegion', 'region_code', 'code');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\LocationProvince', 'province_code', 'code');
    }

    public function municipality()
    {
        return $this->belongsTo('App\Models\LocationMunicipality', 'municipality_code', 'code');
    }

    public function barangay()
    {
        return $this->belongsTo('App\Models\LocationBarangay', 'barangay_code', 'code');
    }
}
