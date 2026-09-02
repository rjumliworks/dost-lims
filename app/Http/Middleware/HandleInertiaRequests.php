<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\User;
use App\Models\Target;
use App\Models\Customer;
use App\Models\AgencyConfiguration;
use App\Models\ListStatus;
use App\Models\TsrAmendment;
use App\Models\TsrSampleAmendment;
use App\Models\TsrSampleReport;
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
            'user' => \Auth::guard('web')->check()
                ? new UserResource(
                    User::with('profile.facility', 'certificate')
                        ->find(\Auth::guard('web')->id())
                )
                : null,
            'roles' => \Auth::guard('web')->check()
                ? \Auth::guard('web')->user()
                    ->roles()
                    ->where('user_roles.is_active', 1)
                    ->pluck('name')
                : null,
            'customer' => \Auth::guard('customer')->check()
                ? Customer::with('contact','customer_name')->find(\Auth::guard('customer')->id())
                : null,
            'is_gad' => str_starts_with($request->getHost(), 'gad.'),
            'show' => (\Auth::guard('web')->check()) ? AgencyConfiguration::value('show_others') : null,
            'functionalities' => (\Auth::guard('web')->check()) ? $this->functionalities() : null,
            'years' => (\Auth::guard('web')->check()) ? Target::distinct()->orderBy('year','desc')->pluck('year') : null,
            'notifications' => (\Auth::guard('web')->check()) ? [
                'requests' => [
                    'count' => $this->pendingRequestsCount(),
                    'items' => $this->pendingRequestsItems(),
                ],
                'signing' => [
                    'count' => $this->pendingSigningCount(),
                    'items' => $this->pendingSigningItems(),
                ],
            ] : null,
            'flash' => [
                'data'    => session('data') ?? null,
                'message' => session('message') ?? null,
                'info'    => session('info') ?? null,
                'status'  => session('status') ?? null,
                'type'    => session('type') ?? null,
            ],
        ];
    }

    private function functionalities(): array
    {
        $defaults = AgencyConfiguration::defaultFunctionalities();

        if (\Auth::guard('web')->user()->hasRole('Administrator')) {
            return $defaults;
        }

        $agencyId = \Auth::guard('web')->user()->profile?->agency_id;

        if (! $agencyId) {
            return $defaults;
        }

        $config = AgencyConfiguration::withoutGlobalScopes()->where('agency_id', $agencyId)->first();

        return array_merge($defaults, $config?->functionalities ?? []);
    }

    private function pendingRequestsCount(): int
    {
        $pendingStatusId = $this->pendingAmendmentStatusId();

        return TsrSampleAmendment::where('status_id', $pendingStatusId)->count()
            + TsrAmendment::where('status_id', $pendingStatusId)->count();
    }

    private function pendingRequestsItems()
    {
        $pendingStatusId = $this->pendingAmendmentStatusId();

        $sampleItems = TsrSampleAmendment::with(['requestedBy:id', 'requestedBy.profile', 'sample:id,code,tsr_id', 'sample.tsr:id'])
            ->where('status_id', $pendingStatusId)
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(function ($amendment) {
                return [
                    'reference' => $amendment->sample?->tsr?->reference,
                    'name' => $amendment->requestedBy?->profile?->fullname,
                    'avatar' => $amendment->requestedBy?->profile?->avatar,
                    'content' => 'Requested a description update for sample ' . ($amendment->sample?->code ?? ''),
                    'time' => \Carbon\Carbon::parse($amendment->getRawOriginal('created_at'))->diffForHumans(),
                    'sort' => $amendment->getRawOriginal('created_at'),
                ];
            });

        $dueDateItems = TsrAmendment::with(['requestedBy:id', 'requestedBy.profile', 'tsr:id,code'])
            ->where('status_id', $pendingStatusId)
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(function ($amendment) {
                return [
                    'reference' => $amendment->tsr?->reference,
                    'name' => $amendment->requestedBy?->profile?->fullname,
                    'avatar' => $amendment->requestedBy?->profile?->avatar,
                    'content' => 'Requested a due date change for ' . ($amendment->tsr?->code ?? ''),
                    'time' => \Carbon\Carbon::parse($amendment->getRawOriginal('created_at'))->diffForHumans(),
                    'sort' => $amendment->getRawOriginal('created_at'),
                ];
            });

        return $sampleItems->concat($dueDateItems)
            ->sortByDesc('sort')
            ->take(5)
            ->values()
            ->map(fn ($item) => collect($item)->except('sort')->all());
    }

    private function pendingAmendmentStatusId()
    {
        return ListStatus::where('type', 'Amendment')->where('is_active', 1)->value('id');
    }

    private function pendingSigningCount(): int
    {
        $userId = \Auth::guard('web')->id();

        return $this->pendingSigningQuery($userId)->count();
    }

    private function pendingSigningItems()
    {
        $userId = \Auth::guard('web')->id();

        return $this->pendingSigningQuery($userId)
            ->with(['lists.sample:id,code', 'user:id', 'user.profile'])
            ->latest('id')
            ->limit(5)
            ->get()
            ->map(function ($report) {
                return [
                    'reference' => $report->reference,
                    'name' => $report->user?->profile?->fullname,
                    'avatar' => $report->user?->profile?->avatar,
                    'sample_code' => $report->lists->first()?->sample?->code,
                    'time' => \Carbon\Carbon::parse($report->getRawOriginal('created_at'))->diffForHumans(),
                ];
            })
            ->values();
    }

    private function pendingSigningQuery($userId)
    {
        return TsrSampleReport::whereHas('signatory', function ($q) use ($userId) {
            $q->where(function ($query) use ($userId) {
                $query->where('analyzed_by', $userId)->where('status_id', 38);
            })->orWhere(function ($query) use ($userId) {
                $query->where('certified_by', $userId)->where('status_id', 39);
            })->orWhere(function ($query) use ($userId) {
                $query->where('approved_by', $userId)->where('status_id', 40);
            });
        });
    }
}
