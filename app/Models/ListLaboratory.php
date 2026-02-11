<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListLaboratory extends Model
{
    public function fees()
    {
        return $this->morphMany('App\Models\TestserviceAddon', 'typeable');
    }
}
