<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CustomerName extends Model
{
    use LogsActivity;

    protected $fillable = ['name','has_branches','is_active','industry_id','classification_id','type_id'];

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            if (! auth()->guard('web')->check()) {
                return;
            }
            if (Auth::check()) {
                $builder->where('agency_id', Auth::user()->profile->agency_id);
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && empty($model->agency_id)) {
                $model->agency_id = Auth::user()->profile->agency_id;
            }
        });
    }

    public function customer()
    {
        return $this->hasMany('App\Models\Customer', 'name_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'type_id', 'id');
    }

    public function classification()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'classification_id', 'id');
    }

    public function industry()
    {
        return $this->belongsTo('App\Models\ListIndustry', 'industry_id', 'id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['name', 'has_branches', 'is_active','industry_id','classification_id','type_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Name')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
