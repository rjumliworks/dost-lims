<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceOpItem extends Model
{
     protected $fillable = [
        'amount',
        'op_id',
        'tsr_id'
    ];

    public function op()
    {
        return $this->belongsTo('App\Models\FinanceOp', 'op_id', 'id');
    }

    public function itemable()
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
