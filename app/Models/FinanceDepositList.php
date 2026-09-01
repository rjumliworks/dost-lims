<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceDepositList extends Model
{
    protected $fillable = [
        'finance_deposit_id',
        'finance_receipt_id',
    ];

    public function deposit()
    {
        return $this->belongsTo('App\Models\FinanceDeposit', 'finance_deposit_id', 'id');
    }

    public function receipt()
    {
        return $this->belongsTo('App\Models\FinanceReceipt', 'finance_receipt_id', 'id');
    }
}
