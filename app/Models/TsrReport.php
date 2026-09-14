<?php

namespace App\Models;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TsrReport extends Model
{
    use LogsActivity;

    protected $fillable = ['information','tsr_id','secret_key'];

    public function tsr()
    {
        return $this->belongsTo('App\Models\Tsr', 'tsr_id', 'id');
    }

    public function setSecretKeyAttribute($value)
    {
        $this->attributes['secret_key'] = Crypt::encryptString($value);
    }

    public function getSecretKeyAttribute($value)
    {
        return ($value) ? Crypt::decryptString($value) : null;
    }

    public function setInformationAttribute($value)
    {
        $this->attributes['information'] = Crypt::encryptString($value);
    }

    public function getInformationAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly(['tsr_id'])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Report')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
