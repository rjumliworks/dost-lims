<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = ['year','data','is_completed','agency_id'];

    public function breakdowns()
    {
        return $this->hasMany('App\Models\TargetBreakdown', 'target_id');
    }
    
    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            $agencyId = Auth::user()->profile?->agency_id;
            if (! $agencyId) {
                abort(403, 'User has no agency assigned.');
            }
            $builder->where('agency_id', $agencyId);
        });
    }
}
