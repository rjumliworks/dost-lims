<?php

namespace App\Http\Controllers\Customer;

use App\Models\Tsr;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return inertia('Customer/Dashboard/Index');
    }

    public function fetch(Request $request){
        return array_merge(
            $this->dashboard($request)
        );
    }

    public function dashboard($request){
        return [
            'counts' => $this->counts($request),
        ];
    }

    private function counts($request){
        return [
            $this->forpayment($request),
            $this->ongoing($request),
            $this->completed($request)
        ];
    }

    private function forpayment($request){
        $year = $request->year;
        $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $series = [];
        $data = Tsr::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->where('status_id',2) //status is completed
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
            'name' => 'For Payment',
            'data' => $data
        ];
        array_push($series,$info);
        return $arr = [
            'name' => 'For Payment',
            'icon' => 'ri-hand-coin-fill',
            'color' => '',
            'series' => $series,
            'total' => Tsr::when($month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })->whereYear('created_at',$year)->whereIn('status_id',[2])->count()
        ];
    }

    private function ongoing($request){
        $year = $request->year;
        $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $series = [];
        $data = Tsr::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->where('status_id',3) //status is completed
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
            'name' => 'For Payment',
            'data' => $data
        ];
        array_push($series,$info);
        return $arr = [
            'name' => 'Ongoing',
            'icon' => 'ri-hand-coin-fill',
            'color' => '',
            'series' => $series,
            'total' => Tsr::when($month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })->whereYear('created_at',$year)->whereIn('status_id',[3])->count()
        ];
    }

    private function completed($request){
        $year = $request->year;
        $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $series = [];
        $data = Tsr::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->where('status_id',4) //status is completed
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
            'name' => 'Completed',
            'data' => $data
        ];
        array_push($series,$info);
        return $arr = [
            'name' => 'Completed',
            'icon' => 'ri-hand-coin-fill',
            'color' => '',
            'series' => $series,
            'total' => Tsr::when($month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })->whereYear('created_at',$year)->whereIn('status_id',[4])->count()
        ];
    }
}
