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
                'type' => 'Pending TSRs for Release',
                'total' => TsrRelease::whereHas('tsr', function ($query) use ($year){
                    $query->whereYear('created_at',$year);
                })->where('status_id',26)->count(),
                'status' => 26
            ],
            [
                'name' => 'Mailed TSR\'s',
                'icon' => 'ri-checkbox-circle-fill',
                'color' => '',
                'type' => 'Mailed TSRs for Release',
                'total' => TsrRelease::whereHas('tsr', function ($query) use ($year){
                    $query->whereYear('created_at',$year);
                })->where('status_id',43)->count(),
                'status' => 43
            ],
            [
                'name' => 'Released TSR\'s',
                'icon' => 'ri-checkbox-circle-fill',
                'color' => '',
                'type' => 'Released TSRs',
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
                'name' => 'Pick-up & Email',
                'description' => 'Released by pickup and email',
                'count' => TsrRelease::whereNotNull('released_at')->whereNotNull('mailed_at')->whereYear('created_at',$year)->where('status_id',27)->count(),
                'icon' => 'ri-exchange-fill fs-20',
                'color' => 'text-primary'
            ],
            [
                'name' => 'Pick-up',
                'description' => 'Released through customer pickup',
                'count' => TsrRelease::whereNotNull('released_at')->where('status_id',27)->whereYear('created_at',$year)->count(),
                'icon' => 'ri-hand-coin-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Email',
                'description' => 'Released through email',
                'count' => TsrRelease::whereNotNull('mailed_at')->whereYear('created_at',$year)->count(),
                'icon' => 'ri-mail-fill fs-20',
                'color' => 'text-info'
            ],
            [
                'name' => 'Internal',
                'description' => 'Internal agency use only',
                'count' => Tsr::where('release_id',15)->whereYear('created_at',$year)->count(),
                'icon' => 'ri-information-fill fs-20',
                'color' => 'text-warning'
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
