<?php

namespace App\Services\Common;

use App\Models\AgencyFacility;
use App\Models\User;
use App\Models\UserFacilityVisibility as UserFacilityVisibilityModel;

class FacilityVisibility
{
    /**
     * The TSR facilities a user can see when an administrator hasn't
     * customized their access: their own facility, widened to every
     * facility in the agency only when they're stationed at a regional
     * facility and hold the Customer Relation Officer or Laboratory Head
     * role.
     */
    public static function defaultFacilityIds(User $user): array
    {
        $profile = $user->profile;

        if (! $profile || ! $profile->facility_id) {
            return [];
        }

        $isRegional = (bool) ($profile->facility->is_regional ?? false);

        $hasEligibleRole = $isRegional && $user->roles()
            ->whereIn('name', ['Customer Relation Officer', 'Laboratory Head'])
            ->where('user_roles.is_active', 1)
            ->exists();

        if ($hasEligibleRole) {
            return AgencyFacility::where('agency_id', $profile->agency_id)->pluck('id')->all();
        }

        return [$profile->facility_id];
    }

    /**
     * The facilities actually in effect for a user: an administrator's
     * saved override if one exists, otherwise the computed default.
     */
    public static function effectiveFacilityIds(User $user): array
    {
        $override = UserFacilityVisibilityModel::where('user_id', $user->id)->first();

        return $override ? $override->facility_ids : self::defaultFacilityIds($user);
    }
}
