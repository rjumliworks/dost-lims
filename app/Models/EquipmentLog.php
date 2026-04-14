<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EquipmentLog extends Model
{
    use LogsActivity;
    
    protected $fillable = [
        'is_calibrated',
        'calibration_due',
        'date',
        'note',
        'next_date',
        'equipment_id',
        'user_id'
    ];

    public function equipment()
    {
        return $this->belongsTo('App\Models\Equipment', 'equipment_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'type_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
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
            'is_calibrated',
            'date',
            'note',
            'next_due'
            ])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Equipment Logs')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
