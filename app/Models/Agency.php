<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'name',
        'code',
        'member_since',
        'contact_no',
        'avatar',
        'is_active',
        'type_id',
        'member_id'
    ];

    protected $appends = ['reference'];
    
    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'type_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\AgencyAddress', 'agency_id');
    }

    public function discounts()
    {
        return $this->hasMany('App\Models\AgencyDiscount', 'agency_id');
    }

    public function facilities()
    {
        return $this->hasMany('App\Models\AgencyFacility', 'agency_id');
    }

    public function configuration()
    {
        return $this->hasOne('App\Models\AgencyConfiguration', 'agency_id');
    }

    public function fees()
    {
        return $this->morphMany('App\Models\TestserviceAddon', 'typeable');
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
