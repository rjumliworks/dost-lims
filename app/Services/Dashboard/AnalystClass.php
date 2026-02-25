<?php

namespace App\Services\Dashboard;

use Carbon\Carbon;
use App\Models\UserRole;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;

class AnalystClass
{
    public function laboratories(){
        $data = UserRole::with('laboratory:id,name')->where('user_id',\Auth::user()->id)->whereIn('role_id',[5,10])->get()->map(function ($item) {
            return [
                'value' => $item->laboratory->id ?? null,
                'name' => $item->laboratory->name ?? null,
            ];
        });
        return $data;
    }

    public function tasks($request){
        return [
            [
                'name' => 'Ongoing Test',
                'description' => 'Tests conducted by the analyst',
                'count' => TsrAnalysis::where('status_id',11)->where('started_by',\Auth::user()->id)->whereYear('start_at',now())->count(),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Tests Performed',
                'description' => 'Tests conducted by the analyst',
                'count' => TsrAnalysis::where('status_id',12)->where('started_by',\Auth::user()->id)->whereYear('start_at',now())->count(),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Total Test Cost',
                'description' => 'Cost of all tests performed by the analyst',
                'count' => '₱' . number_format(TsrAnalysis::where('status_id',12)->where('started_by',\Auth::user()->id)->whereYear('start_at',now())->sum('fee'),2),
                'icon' => 'ri-information-fill fs-20',
                'color' => 'text-info'
            ]
        ];
    }

    public function reminders($request){
        $laboratory = \Auth::user()->myroles[0]->laboratory_id;
        return [ 
            [
                'name' => 'Due Soon',
                'description' => '5 days ahead of the due date',
                'count' => 
                TsrSample::whereHas('tsr',function ($query) use ($laboratory) {
                    $query->whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])->where('status_id',3)->where('laboratory_id',$laboratory);
                })
                ->whereHas('analyses', function ($query){
                    $query->whereIn('status_id',[10,11]);
                })
                ->count(),
                'icon' => 'ri-time-fill fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Overdue Request',
                'description' => 'Keep track of all laboratory tasks',
                'count' => TsrSample::where('is_completed',0)
                ->whereHas('tsr',function ($query) use ($laboratory) {
                    $query->whereDate('due_at','<',Carbon::now())->where('laboratory_id',$laboratory)->whereNotIn('status_id',[4,5]);
                })->count(),
                'icon' => 'ri-error-warning-fill fs-20',
                'color' => 'text-danger'
            ],
              [
                'name' => 'Completed with no report number',
                'description' => 'Please generate a report number.',
                'count' => TsrSample::whereHas('tsr',function ($query) use ($laboratory) {
                    $query->where('status_id',4)->where('due_at','<',Carbon::now())->where('laboratory_id',$laboratory);
                })
                ->whereDoesntHave('report')
                ->whereHas('analyses', function ($query) {
                    $query->where('status_id', 12);
                })->count(),
                'icon' => 'ri-alert-fill fs-20',
                'color' => 'text-success'
            ]
        ];
    }

    public function performance($request){
        $userId = ($request->id) ? $request->id : \Auth::user()->id;
        $year = $request->year;
        $month = $request->month;
        $startMonth = ($month == 'January - June') ? 1 : 7;
        $endMonth = $startMonth + 5;
        $laboratory = $request->laboratory;

        $monthlyCounts = [];

        for ($m = $startMonth; $m <= $endMonth; $m++) {
            $query = TsrAnalysis::where('status_id', 12)
            ->where('started_by', $userId)
            ->whereHas('sample', function ($query) use ($laboratory) {
                $query->whereHas('tsr', function ($query) use ($laboratory) {
                    $query->when($laboratory, function ($query) use ($laboratory) {
                            $query->where('laboratory_id',$laboratory);
                        });
                });
            })->whereYear('start_at', $year)->whereMonth('start_at', $m);

            $count = $query->count();
            $totalCost = round($query->sum('fee'), 2);

            $monthName = Carbon::create()->month($m)->format('F');
            $monthlyData[$monthName] = [
                'tests_performed' => $count,
                'total_cost' => $totalCost
            ];
        }

        return $monthlyData;
    }
}
