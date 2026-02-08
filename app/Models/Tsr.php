<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Tsr extends Model
{
    use LogsActivity;

    protected $appends = ['reference'];
    protected $fillable = [
        'code',
        'laboratory_id',
        'facility_id',
        'agency_id',
        'status_id',
        'purpose_id',
        'customer_id',
        'conforme_id',
        'received_by',
        'due_at',
        'is_referral',
        'is_onsite',
        'is_first',
        'created_at'
    ];

    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
    }

    public function samples(){ return $this->hasMany('App\Models\TsrSample', 'tsr_id');}
    public function payment(){ return $this->hasOne('App\Models\TsrPayment', 'tsr_id');}
    public function release(){ return $this->hasOne('App\Models\TsrRelease', 'tsr_id');}
    public function referral(){ return $this->hasOne('App\Models\TsrReferral', 'tsr_id');}
    public function report(){ return $this->hasOne('App\Models\TsrReport', 'tsr_id');}

    public function status(){ return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');}
    public function purpose(){ return $this->belongsTo('App\Models\ListDropdown', 'purpose_id', 'id');}
    public function customer(){ return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');}
    public function conforme(){ return $this->belongsTo('App\Models\CustomerConforme', 'conforme_id', 'id');}
    public function received(){ return $this->belongsTo('App\Models\User', 'received_by', 'id');}
    public function laboratory(){ return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');}
    public function facility(){ return $this->belongsTo('App\Models\AgencyFacility', 'facility_id', 'id');}
    public function agency(){ return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');}
    
    public function transaction(){ return $this->morphOne('App\Models\WalletTransaction', 'transacable');}
    public function remarkable(){ return $this->morphOne('App\Models\TsrRemark', 'remarkable');}
    public function services(){ return $this->morphMany('App\Models\TsrService', 'typeable');}
    
    public function getDueAtAttribute($value){ return ($value) ? date('F d, Y', strtotime($value)) : null;}
    public function getUpdatedAtAttribute($value){ return date('M d, Y g:i a', strtotime($value));}
    public function getCreatedAtAttribute($value){ return date('F d, Y g:i a', strtotime($value));}

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly([
            'code',
            'laboratory_id',
            'facility_id',
            'agency_id',
            'status_id',
            'purpose_id',
            'customer_id',
            'conforme_id',
            'received_by',
            'due_at',
            'is_referral',
            'is_onsite',
            'is_first'
        ])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('TSR')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            if (! Auth::check()) {
                return;
            }
            $agencyId = Auth::user()->profile?->agency_id;
            if (! $agencyId) {
                abort(403, 'User has no agency assigned.');
            }

            $builder->where('agency_id', $agencyId);
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                $model->received_by = $user->id;

                if (empty($model->agency_id)) {
                    $model->agency_id = $user->profile?->agency_id;
                    $model->facility_id = $user->profile?->facility_id;
                }
            }
        });
    }

    public function createPayment(array $data): void
    {
        $this->payment()->create([
            'status_id' => $data['is_free'] ? 8 : 6,
            'is_free'   => $data['is_free'],
            'discount_id' => $data['discount_id'],
            'paid_at'   => $data['is_free'] ? now() : null,
        ]);
    }

    public function createReferral(array $data): void
    {
        $this->referral()->create($data);
    }
}
