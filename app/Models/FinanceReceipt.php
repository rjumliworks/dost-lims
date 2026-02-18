<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class FinanceReceipt extends Model
{
    protected $fillable = [
        'number',
        'op_id',
        'orseries_id',
        'deposit_id',
        'created_by',
        'agency_id',
        'is_deposited',
        'is_cancelled'
    ];

    public function getNumberAttribute($value)
    {
        return preg_replace('/\D/', '', $value);
    }

    public function wallet()
    {
        return $this->morphOne('App\Models\WalletTransaction', 'transacable');
    }

    public function detail()
    {
        return $this->hasOne('App\Models\FinanceReceiptDetail', 'receipt_id');
    }

    public function deposit()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'deposit_id', 'id');
    }

    public function op()
    {
        return $this->belongsTo('App\Models\FinanceOp', 'op_id', 'id');
    }

    public function createdby()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function transaction()
    {
        return $this->morphOne('App\Models\WalletTransaction', 'transacable');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('F d, Y', strtotime($value));
    }

    public function remarkable(){ return $this->morphOne('App\Models\FinanceRemark', 'remarkable');}

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
}
