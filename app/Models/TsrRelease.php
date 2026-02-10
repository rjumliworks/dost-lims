<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TsrRelease extends Model
{
    protected $fillable = ['released_at','user_id','status_id','tsr_id'];

    public function tsr()
    {
        return $this->belongsTo('App\Models\Tsr', 'tsr_id', 'id');
    }

    public function mode(){ return $this->belongsTo('App\Models\ListData', 'release_id', 'id');}

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\ListStatus', 'status_id', 'id');
    }

    public function getReleasedAtAttribute($value)
    {
        return ($value) ? date('F d, Y', strtotime($value)) : null;
    }
}
