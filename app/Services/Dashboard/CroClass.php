<?php

namespace App\Services\Dashboard;

use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Models\TsrRelease;
use Carbon\Carbon;

class CroClass
{
    public function __construct()
    {
        $this->start = now()->copy()->startOfMonth()->format('Y-m-d');
        $this->end = now()->copy()->endOfMonth()->format('Y-m-d');
    }
    
    public function dashboard($request){
        return [
            'counts' => $this->counts($request),
            'reminders' => $this->reminders($request),
            'statuses' => $this->statuses($request)
        ];
    }

    public function counts($request){
        return [
            $this->ongoing($request),
            $this->tsrs($request),
            $this->samples($request),
            $this->testservices($request),
        ];
    }

    private function ongoing($request){
        $series = [];
        $data = Tsr::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->where('status_id',3) 
        ->whereBetween('created_at', [$this->start, $this->end])
        ->groupBy(\DB::raw('DATE(created_at)'))
        ->orderBy(\DB::raw('DATE(created_at)'))
        ->get()->map(function ($item) {
            return [
                'x' => date('F d, Y',strtotime($item->x)),
                'y' => $item->y
            ];
        });
        $info = [
            'name' => 'Ongoing Request',
            'data' => $data
        ];
        array_push($series,$info);
        return $arr = [
            'name' => 'Ongoing Request',
            'icon' => 'ri-loader-2-line bx-spin text-purple fs-24',
            'color' => 'bg-info-subtle',
            'series' => $series,
            'total' => Tsr::where('status_id',3)->count() //whereBetween('created_at',[$this->start,$this->end])->
        ];
    }

    private function tsrs($request){
        $year = $request->year;
        $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $series = [];
        $data = Tsr::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->whereIn('status_id',[1,2,3,4]) //status is completed
        // ->whereBetween('created_at', [$this->start, $this->end])
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('created_at', $month);
        })
        ->whereYear('created_at', $year)
        ->groupBy(\DB::raw('DATE(created_at)'))
        ->orderBy(\DB::raw('DATE(created_at)'))
        ->get()->map(function ($item) {
            return [
                'x' => date('F d, Y',strtotime($item->x)),
                'y' => $item->y
            ];
        });
        $info = [
            'name' => 'Customer Served',
            'data' => $data
        ];
        array_push($series,$info);
        return $arr = [
            'name' => 'Customer Served',
            'icon' => 'ri-hand-coin-fill',
            'color' => '',
            'series' => $series,
            'total' => Tsr::when($month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })->whereYear('created_at',$year)->whereIn('status_id',[1,2,3,4])->count()
        ];
    }

    private function samples($request){
        $year = $request->year;
        $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $series = [];
        $data = TsrSample::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->whereHas('tsr', function ($query){
            $query->whereIn('status_id',[1,2,3,4]);
        })
        // ->whereBetween('created_at', [$this->start, $this->end])
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('created_at', $month);
        })
        ->whereYear('created_at', $year)
        ->groupBy(\DB::raw('DATE(created_at)'))
        ->orderBy(\DB::raw('DATE(created_at)'))
        ->get()->map(function ($item) {
            return [
                'x' => date('F d, Y',strtotime($item->x)),
                'y' => $item->y
            ];
        });
        $info = [
            'name' => 'Samples Received',
            'data' => $data
        ];
        array_push($series,$info);
        return $arr = [
            'name' => 'Samples Received',
            'icon' => 'ri-inbox-archive-fill',
            'color' => '',
            'series' => $series,
            'total' => TsrSample::when($month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })->whereYear('created_at', $year)->whereHas('tsr', function ($query){
                $query->whereIn('status_id',[1,2,3,4]);
            })->count()
        ];
    }

    private function testservices($request){
        $year = $request->year;
        $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $series = [];
        $data = TsrAnalysis::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->whereHas('sample', function ($query){
            $query->whereHas('tsr', function ($query){
                $query->whereIn('status_id',[1,2,3,4]);
            });
        })
        // ->whereBetween('created_at', [$this->start, $this->end])
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('created_at', $month);
        })
        ->whereYear('created_at', $year)
        ->groupBy(\DB::raw('DATE(created_at)'))
        ->orderBy(\DB::raw('DATE(created_at)'))
        ->get()->map(function ($item) {
            return [
                'x' => date('F d, Y',strtotime($item->x)),
                'y' => $item->y
            ];
        });
        $info = [
            'name' => 'Services Conducted',
            'data' => $data
        ];
        array_push($series,$info);
        return $arr = [
            'name' => 'Services Conducted',
            'icon' => 'ri-flask-fill',
            'color' => '',
            'series' => $series,
            'total' => TsrAnalysis::when($month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })->whereYear('created_at', $year)->whereHas('sample', function ($query){
                    $query->whereHas('tsr', function ($query){
                        $query->whereIn('status_id',[1,2,3,4]);
                    });
                })->count()
        ];
    }

    public function reminders($request){
        
        return [
            [
                'name' => 'Ongoing Request',
                'description' => '5 days ahead of the due date',
                'count' => Tsr::where('status_id',3)->count(),
                'icon' => 'ri-loader-2-line bx-spin fs-20',
                'color' => 'text-purple'
            ],
            [
                'name' => 'Due Soon',
                'description' => '5 days ahead of the due date',
                'count' => Tsr::whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])->where('status_id','!=',4)->count(),
                'icon' => 'ri-error-warning-line fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Overdue Request',
                'description' => 'Keep track of all laboratory tasks',
                'count' => Tsr::whereDate('due_at','<',now())->whereNotIn('status_id',[4,5])->count(),
                'icon' => 'ri-error-warning-fill bx-tada fs-20',
                'color' => 'text-danger'
            ],
            [
                'name' => 'For Release',
                'description' => 'Reports ready for release within 30 days',
                'count' => TsrRelease::where('status_id',26)
                ->where('created_at','>=', Carbon::now()->subDays(30))
                ->count(),
                'icon' => 'ri-alert-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Unclaimed Reports',
                'description' => 'Reports unclaimed for more than 30 days',
                'count' => TsrRelease::where('status_id',26)->where('created_at','<=', Carbon::now()->subDays(30))->count(),
                'icon' => 'ri-information-fill fs-20',
                'color' => 'text-dark'
            ],
        ];
    }

    public function statuses($request){
        
        return [
            [
                'name' => 'Due Soon',
                'description' => '5 days ahead of the due date',
                'count' => Tsr::whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])->where('status_id','!=',4)->count(),
                'icon' => 'ri-error-warning-line fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Overdue Request',
                'description' => 'Keep track of all laboratory tasks',
                'count' => Tsr::whereDate('due_at','<',now())->whereNotIn('status_id',[4,5])->count(),
                'icon' => 'ri-error-warning-fill bx-tada fs-20',
                'color' => 'text-danger'
            ],
            [
                'name' => 'For Release',
                'description' => 'Reports ready for release within 30 days',
                'count' => TsrRelease::where('status_id',26)
                ->where('created_at','>=', Carbon::now()->subDays(30))
                ->count(),
                'icon' => 'ri-alert-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Unclaimed Reports',
                'description' => 'Reports unclaimed for more than 30 days',
                'count' => TsrRelease::where('status_id',26)->where('created_at','<=', Carbon::now()->subDays(30))->count(),
                'icon' => 'ri-information-fill fs-20',
                'color' => 'text-dark'
            ],
        ];
    }
}
