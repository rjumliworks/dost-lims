<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyFacilitySignatory extends Model
{
    protected $fillable = [
        'accountant_id','cashier_id','facility_id','is_cashier'
    ];

    public function accountant()
    {
        return $this->belongsTo('App\Models\User', 'accountant_id', 'id');
    }

    public function cashier()
    {
        return $this->belongsTo('App\Models\User', 'cashier_id', 'id');
    }

    public function facility()
    {
        return $this->belongsTo('App\Models\AgencyFacility', 'facility_id', 'id');
    }
}
