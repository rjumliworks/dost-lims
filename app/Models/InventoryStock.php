<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryStock extends Model
{
    protected $fillable = [
        'code',
        'brand',
        'onhand',
        'quantity',
        'number',
        'cas_number',
        'price',
        'unit',
        'unit_id',
        'supplier',
        'notify',
        'supplier_id',
        'item_id',
        'user_id',
        'bought_at',
        'expired_at',
        'notify_at'
    ];

    public function withdrawals()
    {
        return $this->hasMany('App\Models\InventoryWithdrawal', 'stock_id');
    }

    public function item()
    {
        return $this->belongsTo('App\Models\InventoryItem', 'item_id', 'id');
    }

    public function supp()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id', 'id');
    }

    public function unittype()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'unit_id', 'id');
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = trim(str_replace(',','',$value),'₱');
    }

    public function getPriceAttribute($value)
    {
        return '₱'.number_format($value,2,'.',',');
    }
}
