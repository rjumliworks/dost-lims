<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceDeposit extends Model
{
    protected $fillable = [
        'start','end','total','deposit_id','orseries_id','created_by','agency_id','date',
        'account_id','funding_id'
    ];

    public function deposit()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'deposit_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo('App\Models\ListAccount', 'account_id', 'id');
    }

    public function funding()
    {
        return $this->belongsTo('App\Models\AgencyFund', 'funding_id', 'id');
    }

    public function createdby()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function lists()
    {
        return $this->hasMany('App\Models\FinanceDepositList', 'finance_deposit_id', 'id');
    }

    public function receipts()
    {
        return $this->hasManyThrough(
            'App\Models\FinanceReceipt',
            'App\Models\FinanceDepositList',
            'finance_deposit_id',
            'id',
            'id',
            'finance_receipt_id'
        );
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
