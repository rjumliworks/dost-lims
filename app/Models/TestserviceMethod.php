<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TestserviceMethod extends Model
{
    protected $fillable = [
        'laboratory_id','method_id','reference_id','fee','is_active','agency_id','added_by'
    ];

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('agency_id', Auth::user()->profile->agency_id);
            }
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                $model->added_by = $user->id;

                if (empty($model->agency_id)) {
                    $model->agency_id = $user->profile?->agency_id;
                }
            }
        });
    }

    public function added()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
    }

    public function method()
    {
        return $this->belongsTo('App\Models\TestserviceName', 'method_id', 'id');
    }

    public function reference()
    {
        return $this->belongsTo('App\Models\TestserviceName', 'reference_id', 'id');
    }

    public function laboratory()
    {
        return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function setFeeAttribute($value)
    {
        $this->attributes['fee'] = trim(str_replace(',','',$value),'₱');
    }

    public function getFeeAttribute($value)
    {
        return '₱'.$value;
    }
}
