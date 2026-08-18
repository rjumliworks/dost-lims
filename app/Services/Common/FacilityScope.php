<?php

namespace App\Services\Common;

class FacilityScope
{
    /**
     * Apply the same agency/facility restriction as Tsr's model-level global
     * scope, for raw query builders and manual joins that bypass it (e.g.
     * \DB::table(...) or ->join('tsrs', ...) from an unrelated model).
     */
    public static function apply($query, $agencyColumn = 'tsrs.agency_id', $facilityColumn = 'tsrs.facility_id')
    {
        if (! \Auth::guard('web')->check() || \Auth::user()->hasRole('Administrator')) {
            return $query;
        }

        $profile = \Auth::user()->profile;
        $agencyId = $profile?->agency_id;

        if ($agencyId) {
            $query->where($agencyColumn, $agencyId);
        }

        if ($profile?->facility_id && ! \Auth::user()->hasRole('Laboratory Head')) {
            $query->where($facilityColumn, $profile->facility_id);
        }

        return $query;
    }
}
