<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Equipment extends Model
{
    use LogsActivity;

    protected $fillable = [
        'code',
        'name',
        'calibration_due',
        'calibration_program',
        'calibration_testpoints',
        'maintenance_due',
        'maintenance_plan',
        'status_id',
        'laboratory_id',
        'agency_id',
    ];

    protected $appends = ['reference'];

    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
    }


    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function laboratory()
    {
        return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function info()
    {
        return $this->hasOne('App\Models\EquipmentInfo', 'equipment_id');
    }

    public function logs()
    {
        return $this->hasMany('App\Models\EquipmentLog', 'equipment_id')->orderBy('created_at','DESC');
    }

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
        ->logOnly([ 
            'code',
            'name',
            'laboratory_id',
            'agency_id',
            ])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Equipment')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
