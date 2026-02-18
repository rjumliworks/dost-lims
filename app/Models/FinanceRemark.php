<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceRemark extends Model
{
     protected $fillable = [
        'amount',
        'reason',
        'type_id',
        'user_id'
    ];

    public function remarkable()
    {
        return $this->morphTo();
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = trim(str_replace(',','',$value),'₱');
    }

    public function getAmountAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }
}
