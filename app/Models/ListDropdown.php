<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListDropdown extends Model
{
    use HasFactory;

    public function designationable()
    {
        return $this->morphOne('App\Models\Signatory', 'designationable');
    }

    public function inventory_category()
    {
        return $this->hasMany('App\Models\InventoryItem', 'category_id');
    } 
}
