<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetItem extends Model
{
    public function item()
    {
        return $this->belongsTo('App\Models\ListObjectiveItem', 'item_id');
    }
}
