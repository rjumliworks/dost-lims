<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Testservice extends Model
{
    use LogsActivity;

    protected $fillable = [
        'laboratory_id','testname_id','method_id','is_active','status_id'
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

    public function fees()
    {
        return $this->morphMany('App\Models\TestserviceAddon', 'typeable');
    }

    public function samples()
    {
        return $this->hasMany('App\Models\TestserviceSample', 'testservice_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function testname()
    {
        return $this->belongsTo('App\Models\TestserviceName', 'testname_id', 'id');
    }

    public function method()
    {
        return $this->belongsTo('App\Models\TestserviceMethod', 'method_id', 'id');
    }

    public function laboratory()
    {
        return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function added()
    {
        return $this->belongsTo('App\Models\User', 'added_by', 'id');
    }
    
    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['laboratory_id','testname_id','method_id','is_active','status_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName} the user information")
        ->useLogName('Testservice')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
