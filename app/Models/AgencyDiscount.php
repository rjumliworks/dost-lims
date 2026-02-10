<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AgencyDiscount extends Model
{
    protected $fillable = [
        'agency_id','discount_id','is_occasional','is_active'
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function discount()
    {
        return $this->belongsTo('App\Models\ListDiscount', 'discount_id', 'id');
    }

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            if (! Auth::check()) {
                return;
            }
            $user = Auth::user();
            if ($user->hasRole('Administrator')) {
                return;
            }
            $agencyId = $user()->profile?->agency_id;
            if (! $agencyId) {
                abort(403, 'User has no agency assigned.');
            }

            $builder->where('agency_id', $agencyId);
        });
    }
}
