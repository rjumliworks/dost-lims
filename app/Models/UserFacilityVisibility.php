<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFacilityVisibility extends Model
{
    protected $fillable = [
        'user_id', 'facility_ids'
    ];

    protected $casts = [
        'facility_ids' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
