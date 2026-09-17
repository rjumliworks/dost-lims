<?php

namespace App\Services\Dashboard;

use App\Models\ListLaboratory;
use App\Models\TsrAnalysis;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class TechnicalManagerClass
{
    protected LabHeadClass $labhead;

    public function __construct(LabHeadClass $labhead)
    {
        $this->labhead = $labhead;
    }

    public function laboratories(){
        $ids = $this->assignedLaboratoryIds();

        return ListLaboratory::whereIn('id', $ids)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
    }

    public function dashboard($request){
        $ids = $this->assignedLaboratoryIds();

        $laboratory = ($request->laboratory && $ids->contains((int) $request->laboratory))
            ? $request->laboratory
            : $ids->first();

        $request->merge(['laboratory' => $laboratory]);

        return array_merge(
            $this->labhead->dashboard($request),
            ['analysts' => $this->analysts($laboratory, $request->year ?: now()->year)]
        );
    }

    public function analysts($laboratory, $year = null){
        if (! $laboratory) {
            return [];
        }

        $year = $year ?: now()->year;
        $agencyId = Auth::user()->profile?->agency_id;

        $userRoles = UserRole::with('user.profile', 'role:id,name')
            ->where('is_active', 1)
            ->whereIn('role_id', [5, 10])
            ->where('laboratory_id', $laboratory)
            ->whereHas('user.profile', fn ($query) => $query->where('agency_id', $agencyId))
            ->get()
            ->unique('user_id');

        $userIds = $userRoles->pluck('user_id');

        $stats = TsrAnalysis::whereIn('status_id', [11, 12])
            ->whereIn('started_by', $userIds)
            ->whereHas('sample.tsr', fn ($query) => $query->where('laboratory_id', $laboratory))
            ->whereYear('start_at', $year)
            ->selectRaw('started_by,
                SUM(CASE WHEN status_id = 11 THEN 1 ELSE 0 END) as ongoing_tests,
                SUM(CASE WHEN status_id = 12 THEN 1 ELSE 0 END) as completed_tests,
                SUM(CASE WHEN status_id = 12 THEN fee ELSE 0 END) as total_cost,
                COUNT(DISTINCT CASE WHEN status_id = 12 THEN sample_id END) as samples_handled')
            ->groupBy('started_by')
            ->get()
            ->keyBy('started_by');

        return $userRoles->map(function ($userRole) use ($stats) {
            $stat = $stats->get($userRole->user_id);

            return [
                'id' => $userRole->user_id,
                'name' => $userRole->user->profile->fullname ?? null,
                'avatar' => $userRole->user->profile->avatar ?? null,
                'role' => $userRole->role->name ?? null,
                'ongoing_tests' => (int) ($stat->ongoing_tests ?? 0),
                'completed_tests' => (int) ($stat->completed_tests ?? 0),
                'samples_handled' => (int) ($stat->samples_handled ?? 0),
                'total_cost' => round((float) ($stat->total_cost ?? 0), 2),
            ];
        })->values();
    }

    private function assignedLaboratoryIds(){
        return UserRole::where('user_id', Auth::id())
            ->where('role_id', 3)
            ->where('is_active', 1)
            ->pluck('laboratory_id')
            ->filter()
            ->unique();
    }
}
