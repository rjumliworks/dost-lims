<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListObjective extends Model
{
     public function type()
    {
        return $this->belongsTo('App\Models\ListDropdown', 'type_id', 'id');
    }
}
