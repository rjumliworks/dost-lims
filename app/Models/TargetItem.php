<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetItem extends Model
{
    protected $fillable = ['count', 'accom', 'is_set', 'is_amount', 'target_id', 'item_id'];

    public function item()
    {
        return $this->belongsTo('App\Models\ListObjectiveItem', 'item_id');
    }
}
