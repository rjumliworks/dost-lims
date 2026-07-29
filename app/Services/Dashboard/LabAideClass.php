<?php

namespace App\Services\Dashboard;

use App\Models\ListDropdown;
use App\Models\ListLaboratory;
use App\Models\TsrSampleDisposal;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;

class LabAideClass
{
    public function dashboard($request){
        return [
            'disposals' => $this->disposals($request),
            'disposed' => $this->disposed($request),
            'overview' => $this->overview($request)
        ];
    }

    public function overview($request){
        $query = TsrSampleDisposal::query()
            ->when($request->laboratory, function ($query) use ($request) {
                $query->whereHas('sample.tsr', function ($q) use ($request) {
                    $q->where('laboratory_id', $request->laboratory);
                });
            })
            ->when($request->year, function ($query) use ($request) {
                $query->whereYear('created_at', $request->year);
            });

        return [
            [
                'name' => 'Total Disposal Requests',
                'total' => (clone $query)->count(),
                'icon' => 'ri-recycle-line',
                'color' => 'text-primary',
            ],
            [
                'name' => 'Pending Disposal',
                'total' => (clone $query)->where('status_id', 28)->count(),
                'icon' => 'ri-time-line',
                'color' => 'text-warning',
            ],
            [
                'name' => 'Completed Disposal',
                'total' => (clone $query)->where('status_id', 29)->count(),
                'icon' => 'ri-checkbox-circle-line',
                'color' => 'text-success',
            ],
        ];
    }

    public function disposed($request){
        $total = TsrSampleDisposal::where('user_id', Auth::id())
            ->where('status_id', 29)
            ->when($request->laboratory, function ($query) use ($request) {
                $query->whereHas('sample.tsr', function ($q) use ($request) {
                    $q->where('laboratory_id', $request->laboratory);
                });
            })
            ->when($request->year, function ($query) use ($request) {
                $query->whereYear('disposed_at', $request->year);
            })
            ->count();

        return [
            'name' => 'My Disposed Samples',
            'total' => $total,
        ];
    }

    public function laboratories(){
        $ids = UserRole::where('user_id', Auth::id())
            ->where('role_id', 9)
            ->where('is_active', 1)
            ->pluck('laboratory_id')
            ->filter()
            ->unique();

        return ListLaboratory::whereIn('id', $ids)->get()->map(function ($item) {
            return [
                'value' => $item->id,
                'name' => $item->name,
            ];
        });
    }

    public function years(){
        return TsrSampleDisposal::whereNotNull('disposed_at')
            ->selectRaw('YEAR(disposed_at) as year')
            ->distinct()
            ->pluck('year')
            ->push((int) date('Y'))
            ->unique()
            ->sortDesc()
            ->values();
    }

    // public function counts($request){
    //     return [
    //         // $this->ongoing($request),
    //         $this->tsrs($request),
    //         $this->samples($request),
    //         $this->testservices($request),
    //     ];
    // }

    // public function reminders($request){
    //     return [
    //         [
    //             'name' => 'Due Soon',
    //             'description' => '5 days ahead of the due date',
    //             'count' => Tsr::whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])->where('status_id','!=',4)->count(),
    //             'icon' => 'ri-error-warning-fill fs-20',
    //             'color' => 'text-warning'
    //         ],
    //         [
    //             'name' => 'Overdue Request',
    //             'description' => 'Keep track of all laboratory tasks',
    //             'count' => Tsr::whereDate('due_at','<',now())->whereNotIn('status_id',[4,5])->count(),
    //             'icon' => 'ri-error-warning-fill fs-20',
    //             'color' => 'text-danger'
    //         ],
    //         [
    //             'name' => 'For Release',
    //             'description' => 'Reports ready for release within 30 days',
    //             'count' => TsrRelease::where('status_id',26)
    //             ->where('created_at','>=', Carbon::now()->subDays(30))
    //             ->count(),
    //             'icon' => 'ri-alert-fill fs-20',
    //             'color' => 'text-success'
    //         ],
    //         [
    //             'name' => 'Unclaimed Reports',
    //             'description' => 'Reports unclaimed for more than 30 days',
    //             'count' => TsrRelease::where('status_id',26)->where('created_at','<=', Carbon::now()->subDays(30))->count(),
    //             'icon' => 'ri-information-fill fs-20',
    //             'color' => 'text-dark'
    //         ],
    //     ];
    // }

    public function disposals($request){
        $laboratory = $request->laboratory;
        $year = $request->year;

        $counts = TsrSampleDisposal::selectRaw('disposal_id, COUNT(*) as total')
            ->where('status_id', 29)
            ->when($laboratory, function ($query) use ($laboratory) {
                $query->whereHas('sample.tsr', function ($q) use ($laboratory) {
                    $q->where('laboratory_id', $laboratory);
                });
            })
            ->when($year, function ($query) use ($year) {
                $query->whereYear('disposed_at', $year);
            })
            ->groupBy('disposal_id')
            ->pluck('total', 'disposal_id');

        $meta = [
            'Collected by Staff' => [
                'description' => 'Waste collected and hauled off by laboratory staff',
                'icon' => 'ri-user-follow-line',
                'color' => 'text-info',
            ],
            'Disposal to Sink after Treatment' => [
                'description' => 'Treated waste released through the laboratory sink',
                'icon' => 'ri-drop-line',
                'color' => 'text-primary',
            ],
            'Disposed to Garbage' => [
                'description' => 'Waste discarded through regular garbage disposal',
                'icon' => 'ri-delete-bin-6-line',
                'color' => 'text-danger',
            ],
            'Forwarded to Chemical Laboratory' => [
                'description' => 'Waste forwarded to the chemical laboratory for handling',
                'icon' => 'ri-flask-line',
                'color' => 'text-warning',
            ],
            'Decontaminate/Autoclave' => [
                'description' => 'Waste sterilized and decontaminated via autoclave',
                'icon' => 'ri-fire-line',
                'color' => 'text-success',
            ],
        ];

        return ListDropdown::where('classification', 'Disposal')
            ->where('is_active', 1)
            ->get()
            ->map(function ($item) use ($counts, $meta) {
                $info = $meta[$item->name] ?? [
                    'description' => 'Completed sample disposal record',
                    'icon' => 'ri-recycle-line',
                    'color' => 'text-secondary',
                ];

                return [
                    'value' => $item->id,
                    'name' => $item->name,
                    'description' => $info['description'],
                    'icon' => $info['icon'],
                    'color' => $info['color'],
                    'total' => $counts[$item->id] ?? 0,
                ];
            });
    }

}
