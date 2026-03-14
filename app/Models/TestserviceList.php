<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestserviceList extends Model
{
    protected $fillable = ['testservice_id', 'old_id'];

    public function testservice(){ return $this->belongsTo('App\Models\Testservice', 'testservice_id', 'id');}
}
