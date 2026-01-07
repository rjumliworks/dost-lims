<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyConfiguration extends Model
{
    protected $casts = [
        'laboratories' => 'array',
        'form' => 'array',
        'contact' => 'array',
    ];
    
    protected $fillable = [
        'laboratories','form','contact','samplecode_year','show_others','strict_mode','agency_id'
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function getLaboratoriesAttribute($value)
    {
        return json_decode($value, true); 
    }

    public function getFormAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) : $value;
    }
}
