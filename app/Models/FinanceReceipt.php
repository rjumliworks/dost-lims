<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceReceipt extends Model
{
    protected $fillable = [
        'number',
        'op_id',
        'orseries_id',
        'deposit_id',
        'created_by',
        'agency_id',
        'is_deposited'
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
}
