<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    protected $fillable = [
        'code',
        'old_code',
        'name',
        'img',
        'reorder',
        'unit_id',
        'category_id',
        'agency_id',
        'laboratory_id',
        'user_id',
        'is_equipment'
    ];

    public function stocks()
    {
        return $this->hasMany('App\Models\InventoryStock', 'item_id');
    }

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function laboratory()
    {
        return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'category_id', 'id');
    }

    public function unittype()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'unit_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function isBelowReorderLevel()
    {
        $totalStock = $this->stocks()->sum('onhand');
        return $totalStock <= $this->reorder && $totalStock != 0;
    }
}
