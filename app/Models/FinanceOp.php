<?php

namespace App\Models;

use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FinanceOp extends Model
{
    protected $fillable = [
        'code',
        'total',
        'status_id',
        'collection_id',
        'payment_id',
        'created_by',
        'agency_id'
    ];

    protected $appends = ['reference'];

    public function getReferenceAttribute(): string
    {
        return (new Hashids('krad', 10))->encode($this->id);
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
                }
            }
        });
    }

    public function getCodeAttribute($value)
    {
        return preg_replace('/-R\d+$/i', '', $value);
    }

    public function payorable()
    {
        return $this->morphTo();
    }

    public function remarkable(){ return $this->morphOne('App\Models\FinanceRemark', 'remarkable');}

    public function items()
    {
        return $this->hasMany('App\Models\FinanceOpItem', 'op_id');
    }

    public function or()
    {
        return $this->hasMany('App\Models\FinanceReceipt', 'op_id');
    }

    public function activeReceipt()
    {
        return $this->hasOne(\App\Models\FinanceReceipt::class, 'op_id')
            ->where('is_cancelled', 0);
    }

    public function createdby()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function collection()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'collection_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'payment_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('M d, Y g:i a', strtotime($value));
    }

    public function getCreatedAtAttribute($value)
    {
        return date('F d, Y', strtotime($value));
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = trim(str_replace(',','',$value),'₱');
    }

    public function getTotalAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }
}
