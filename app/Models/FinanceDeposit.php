<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceDeposit extends Model
{
    protected $fillable = [
        'start','end','total','deposit_id','orseries_id','created_by','agency_id','date'
    ];

    public function deposit()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'deposit_id', 'id');
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
