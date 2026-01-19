<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TestserviceAddon extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'fee',
        'description',
        'is_additional',
        'is_active',
        'agency_id',
        'added_by'
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

    public function typeable()
    {
        return $this->morphTo();
    }

    public function setFeeAttribute($value)
    {
        $this->attributes['fee'] = trim(str_replace(',','',$value),'₱');
    }

    public function getFeeAttribute($value)
    {
        return '₱'.$value;
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['name','fee','description','is_additional','is_active'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} the user information")
        ->useLogName('Add-ons')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
