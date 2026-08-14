<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AgencyFacilityLaboratory extends Model
{
    protected $fillable = [
        'laboratory_id','facility_id'
    ];

    public function laboratory()
    {
        return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');
    }

    public function facility()
    {
        return $this->belongsTo('App\Models\AgencyFacility', 'facility_id', 'id');
    }

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            if (! Auth::check()) {
                return;
            }
            if (auth()->guard('web')->check()) {
                $user = Auth::user();
                if ($user->hasRole('Administrator')) {
                    return;
                }
                $profile = $user->profile;
                $agencyId = $profile?->agency_id;
                if (! $agencyId) {
                    abort(403, 'User has no agency assigned.');
                }

                $builder->whereHas('facility', function ($query) use ($agencyId) {
                    $query->where('agency_id', $agencyId);
                });

                if ($profile->facility && ! $profile->facility->is_regional) {
                    $builder->where('facility_id', $profile->facility_id);
                }
            }
        });
    }
}
