<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\AgencyConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureFunctionalityEnabled
{
    public function handle(Request $request, Closure $next, string $key): Response
    {
        if (! Auth::guard('web')->check()) {
            return $next($request);
        }

        $user = Auth::guard('web')->user();

        if ($user->hasRole('Administrator')) {
            return $next($request);
        }

        $agencyId = $user->profile?->agency_id;

        if ($agencyId) {
            $config = AgencyConfiguration::withoutGlobalScopes()->where('agency_id', $agencyId)->first();

            if ($config && ! $config->isFunctionalityEnabled($key)) {
                abort(403, 'This module is not enabled for your agency.');
            }
        }

        return $next($request);
    }
}
