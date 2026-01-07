<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyFacilityLaboratory extends Model
{
    protected $fillable = [
        'laboratory_id','facility_id'
    ];

    public function laboratory()
    {
        return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');
    }

    public function facility()
    {
        return $this->belongsTo('App\Models\AgencyFacility', 'facility_id', 'id');
    }
}
