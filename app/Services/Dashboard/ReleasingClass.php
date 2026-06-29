<?php

namespace App\Services\Dashboard;

use Carbon\Carbon;
use App\Models\Tsr;
use App\Models\TsrRelease;
class ReleasingClass
{
     public function dashboard($request,$modes){
        return [
            'counts' => $this->counts($request),
            'modes' => $this->modes($request,$modes),
            'releasing_summary' => $this->releasing_summary($request),
            'releasing_age' => $this->releasing_age($request)
        ];
    }

    private function modes($request,$modes){
        $year = $request->year;
        foreach($modes as $status){
            $status = $status['value'];
            $counts[] = TsrRelease::where('status_id',26)
            ->whereHas('tsr', function ($query) use ($status,$year){
               $query->where('release_id',$status)->whereYear('created_at',$year);
            })
            ->count();
        }
        return $counts;
    }

     public function counts($request){
        $year = $request->year;
        return [
            [
                'name' => 'Pending Released TSR\'s',
                'icon' => 'ri-checkbox-circle-fill',
                'color' => '',
                'total' => TsrRelease::whereHas('tsr', function ($query) use ($year){
                    $query->whereYear('created_at',$year);
                })->where('status_id',26)->count(),
                'status' => 26
            ],
            [
                'name' => 'Mailed TSR\'s',
                'icon' => 'ri-checkbox-circle-fill',
                'color' => '',
                'total' => TsrRelease::whereHas('tsr', function ($query) use ($year){
                    $query->whereYear('created_at',$year);
                })->where('status_id',43)->count(),
                'status' => 43
            ],
            [
                'name' => 'Released TSR\'s',
                'icon' => 'ri-checkbox-circle-fill',
                'color' => '',
                'total' => TsrRelease::whereHas('tsr', function ($query) use ($year){
                    $query->whereYear('created_at',$year);
                })->where('status_id',27)->count(),
                'status' => 27
            ]
        ];
    }

    private function releasing_summary($request){
        $year = $request->year;
        return [
            [
                'name' => 'Unreleased TSRs',
                'description' => 'TSRs awaiting final release to customers',
                'count' => TsrRelease::where('status_id',26)->count(),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Released TSRs',
                'description' => 'TSRs successfully released to customers',
                'count' => TsrRelease::where('status_id',27)->count(),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Completed TSRs',
                'description' => 'The total completed TSRs in the system',
                'count' => Tsr::whereNotIn('status_id',[4])->count(),
                'icon' => 'ri-information-fill fs-20',
                'color' => 'text-info'
            ]
        ];
    }

    public function releasing_age($request){
        $today = Carbon::now();
        $year = $request->year;
        return [
            [
                'name' => '1 Week: Recently Ready',
                'description' => 'Ready within the past week',
                'count' => TsrRelease::whereBetween('created_at', [Carbon::now()->subDays(7),Carbon::now()])->where('status_id',26)->count(),
                'icon' => 'ri-calendar-todo-fill fs-20',
                'color' => 'text-info'
            ],
            [
                'name' => '2 Weeks: Pending Release',
                'description' => 'Ready for up to two weeks, pending action',
                'count' => TsrRelease::whereBetween('created_at', [Carbon::now()->subDays(22),Carbon::now()->subDays(8)])->where('status_id',26)->count(),
                'icon' => 'ri-calendar-todo-fill fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'A Month: Overdue for Release',
                'description' => 'Ready for over a month, requires urgent action',
                'count' => TsrRelease::where('created_at', '<=', Carbon::now()->subDays(22))->where('status_id',26)->count(),
                'icon' => 'ri-calendar-todo-fill fs-20',
                'color' => 'text-danger'
            ]
        ];
    }

}
