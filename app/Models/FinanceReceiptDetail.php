<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceReceiptDetail extends Model
{
    public function receipt()
    {
        return $this->belongsTo('App\Models\FinanceReceipt', 'receipt_id', 'id');
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = trim(str_replace(',','',$value),'₱');
    }

    public function getNumberAttribute($value)
    {
        if (strpos($value, '-DUP-') !== false) {
            return explode('-DUP-', $value)[0];
        }
        return $value;
    }

    public function getAmountAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }
}
