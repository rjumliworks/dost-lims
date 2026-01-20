<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageTestservice extends Model
{
    protected $fillable = [
        'testservice_id','package_id'
    ];

    public function package()
    {
        return $this->belongsTo('App\Models\Package', 'package_id', 'id');
    }

    public function testservice()
    {
        return $this->belongsTo('App\Models\Testservice', 'testservice_id', 'id');
    }
}
