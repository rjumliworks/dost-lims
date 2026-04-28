<?php

namespace App\Http\Controllers\Customer;

use App\Models\Tsr;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Dashboard\CommonClass;
use App\Models\Schedule;
use App\Http\Resources\Public\Customer\TsrResource;
use App\Http\Resources\Others\Schedules\EventResource;

class DashboardController extends Controller
{
    protected CommonClass $common;

    public function __construct(
        CommonClass $common
    ){
        $this->common = $common;
    }

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
            'schedules' => $this->schedules($request),
            'pickups' => $this->pickups($request),
            'tsrs' => $this->tsrs($request)
        ];
    }

    private function counts($request){
        return [
            $this->forpayment($request),
            $this->ongoing($request),
            $this->completed($request)
        ];
    }

    private function tsrs($request){
         $data = Tsr::with('payment.status','status','samples.report.signatory','samples.samplename','samples.analyses')
        ->withCount([
            'samples as total_report_count' => function ($query) {
                $query->select(\DB::raw('COUNT(DISTINCT tsr_sample_reports.code)'))
                    ->join('tsr_sample_reports', 'tsr_sample_reports.sample_id', '=', 'tsr_samples.id');
            },
            'samples as completed_report_count' => function ($query) {
                $query->select(\DB::raw('COUNT(DISTINCT tsr_sample_reports.code)'))
                    ->join('tsr_sample_reports', 'tsr_sample_reports.sample_id', '=', 'tsr_samples.id')
                    ->join('tsr_sample_report_signatories', 'tsr_sample_report_signatories.report_id', '=', 'tsr_sample_reports.id')
                    ->where('tsr_sample_report_signatories.status_id', 42);
            }
        ])
        ->whereIn('status_id',[2,3,4])
        ->where('customer_id',\Auth::guard('customer')->id())
        ->orderBy('created_at','DESC')
        ->get();
        return TsrResource::collection($data);
    }

    private function pickups($request){
        $data = Tsr::whereHas('release', function ($q) {
            $q->where('status_id',26);
        })
        ->where('customer_id',\Auth::guard('customer')->id())
        ->get();
        return $data;
    }

    private function schedules($request){
        $start = now()->startOfWeek();
        $end   = now()->startOfWeek()->addDays(4);
        return EventResource::collection(
            Schedule::with('users.user:id','users.user.profile')
                ->with('information.customer.customer_name','information.customer.address','information.conforme')
                ->whereDate('start', '<=', $end)
                ->whereDate('end', '>=', $start)
                ->orderBy('start','ASC')
                ->whereHas('information', function ($q) {
                    $q->where('customer_id',\Auth::guard('customer')->id());
                })
                ->get()
        );
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
        ->where('customer_id',\Auth::guard('customer')->id())
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
            'color' => 'text-danger',
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
        ->where('customer_id',\Auth::guard('customer')->id())
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
            'icon' => 'ri-indeterminate-circle-fill ',
            'color' => 'text-warning',
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
        ->where('customer_id',\Auth::guard('customer')->id())
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
            'icon' => 'ri-checkbox-circle-fill',
            'color' => 'text-success',
            'series' => $series,
            'total' => Tsr::when($month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })->whereYear('created_at',$year)->whereIn('status_id',[4])->count()
        ];
    }
}
