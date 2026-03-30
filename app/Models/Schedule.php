<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Schedule extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title',
        'is_allday',
        'start',
        'end',
        'event_id',
        'agency_id',
        'user_id'
    ];
    
    public function customer(){ return $this->hasOne('App\Models\ScheduleCustomer', 'customer_id');}
    public function information(){ return $this->hasOne('App\Models\ScheduleInformation', 'customer_id');}
    public function users(){ return $this->hasOne('App\Models\ScheduleUser', 'customer_id');}
    
    public function event(){ return $this->belongsTo('App\Models\ListDropdown', 'event_id', 'id');}
    public function user(){ return $this->belongsTo('App\Models\User', 'user_id', 'id');}
    public function agency(){ return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');}

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('F d, Y g:i a', strtotime($value));
    }
    
    public function updateIfDirty(array $attributes){
        $this->fill($attributes);
        $dirtyAttributes = $this->getDirty();
        if(!empty($dirtyAttributes)) {
            $originalAttributes = array_intersect_key($this->getOriginal(), $dirtyAttributes);
            $updated = $this->update($dirtyAttributes);
            return $updated;
        }
        return false;
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly([ 'title','is_allday','start','end','event_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Schedule')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

     protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            $agencyId = Auth::user()->profile?->agency_id;
            if (! $agencyId) {
                abort(403, 'User has no agency assigned.');
            }

            $builder->where('agency_id', $agencyId);
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                $model->user_id = $user->id;

                if (empty($model->agency_id)) {
                    $model->agency_id = $user->profile?->agency_id;
                }
            }
        });
    }
}
