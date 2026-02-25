<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\User;
use App\Models\Target;
use App\Models\Customer;
use App\Models\AgencyConfiguration;
use App\Http\Resources\UserResource;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'user' =>(\Auth::guard('web')->check()) ? new UserResource(User::with('profile')->where('id',\Auth::user()->id)->first()) : null,
            'roles' => (\Auth::guard('web')->check()) ? \Auth::user()->roles()->where('user_roles.is_active', 1)->pluck('name') : null,
            'show' => (\Auth::guard('web')->check()) ? AgencyConfiguration::value('show_others') : null,
            'viewer' => (\Auth::guard('customer')->check()) ? Customer::with('contact')->find(\Auth::guard('customer')->id()) : null,
            'years' => (\Auth::guard('web')->check()) ? Target::distinct()->pluck('year') : null,
            'flash' => [
                'data'    => session('data') ?? null,
                'message' => session('message') ?? null,
                'info'    => session('info') ?? null,
                'status'  => session('status') ?? null,
                'type'    => session('type') ?? null,
            ],
        ];
    }
}
