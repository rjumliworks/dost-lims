<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Quotation extends Model
{
    use LogsActivity;

    protected $appends = ['reference'];
    protected $fillable = [
        'code',
        'total',
        'subtotal',
        'discount',
        'discount_id',
        'laboratory_id',
        'facility_id',
        'agency_id',
        'status_id',
        'discount_id',
        'purpose_id',
        'release_id',
        'customer_id',
        'conforme_id',
        'created_by',
        'due_at',
        'is_referral',
        'is_onsite',
        'created_at'
    ];

    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
    }

    public function samples(){ return $this->hasMany('App\Models\QuotationSample', 'quotation_id');}
    public function referral(){ return $this->hasOne('App\Models\QuotationReferral', 'quotation_id');}
    public function services(){ return $this->morphMany('App\Models\QuotationService', 'typeable');}
    public function signatory(){ return $this->hasOne('App\Models\QuotationSignatory', 'quotation_id');}

    public function status(){ return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');}
    public function purpose(){ return $this->belongsTo('App\Models\ListDropdown', 'purpose_id', 'id');}
    public function mode(){ return $this->belongsTo('App\Models\ListData', 'release_id', 'id');}
    public function customer(){ return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');}
    public function conforme(){ return $this->belongsTo('App\Models\CustomerConforme', 'conforme_id', 'id');}
    public function received(){ return $this->belongsTo('App\Models\User', 'created_by', 'id');}
    public function laboratory(){ return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');}
    public function facility(){ return $this->belongsTo('App\Models\AgencyFacility', 'facility_id', 'id');}
    public function agency(){ return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');}
    public function discounted(){ return $this->belongsTo('App\Models\ListDiscount', 'discount_id', 'id');}
    
    public function getDueAtAttribute($value){ return ($value) ? date('F d, Y', strtotime($value)) : null;}
    public function getUpdatedAtAttribute($value){ return date('M d, Y g:i a', strtotime($value));}
    public function getCreatedAtAttribute($value){ return date('F d, Y g:i a', strtotime($value));}

    public function getSubtotalAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }

    public function getDiscountAttribute($value)
    {
        return '₱'.$value;
    }

    public function getTotalAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }

    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = $this->cleanMoney($value);
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = $this->cleanMoney($value);
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = $this->cleanMoney($value);
    }

    private function cleanMoney($value)
    {
        return str_replace(['₱', ',', ' '], '', $value);
    }

    public function getActivitylogOptions(): LogOptions {
        return LogOptions::defaults()
        ->logOnly([
            'code',
            'total',
            'subtotal',
            'discount',
            'discount_id',
            'laboratory_id',
            'facility_id',
            'agency_id',
            'status_id',
            'purpose_id',
            'customer_id',
            'conforme_id',
            'created_by',
            'due_at',
            'is_referral',
            'is_onsite'
        ])
        ->setDescriptionForEvent(fn(string $eventName) => "{$eventName}")
        ->useLogName('Quotation')
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
                $model->created_by = $user->id;

                if (empty($model->agency_id)) {
                    $model->agency_id = $user->profile?->agency_id;
                    $model->facility_id = $user->profile?->facility_id;
                }
            }
        });
    }

    public function createReferral(array $data): void
    {
        $this->referral()->create($data);
    }

}
