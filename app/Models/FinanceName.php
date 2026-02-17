<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FinanceName extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name',
        'is_individual'
    ];

    public function payorable()
    {
        return $this->morphOne('App\Models\FinanceOp', 'payorable');
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly([ 'name',
        'is_individual'])
        ->useLogName('Name')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }
}
