<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerQuotation extends Model
{
     protected $fillable = [
        'code',
        'total',
        'subtotal',
        'discount',
        'discount_id',
        'laboratory_id',
        'agency_id',
        'status_id',
        'discount_id',
        'customer_id',
        'conforme_id',
        'created_at'
    ];

    public function samples(){ return $this->hasMany('App\Models\CustomerQuotationSample', 'quotation_id');}

    public function status(){ return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');}
    public function customer(){ return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');}
    public function conforme(){ return $this->belongsTo('App\Models\CustomerConforme', 'conforme_id', 'id');}
    public function laboratory(){ return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');}
    public function agency(){ return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');}
    public function discounted(){ return $this->belongsTo('App\Models\ListDiscount', 'discount_id', 'id');}
    
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
}
