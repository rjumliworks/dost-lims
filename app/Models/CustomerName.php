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

    protected $fillable = ['name', 'has_branches', 'is_active'];

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
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

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['name', 'has_branches', 'is_active'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Name')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
