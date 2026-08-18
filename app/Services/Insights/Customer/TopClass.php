<?php

namespace App\Services\Insights\Customer;

use App\Models\Tsr;
use App\Models\Customer;
use App\Models\ListDropdown;
use App\Http\Resources\DefaultResource;

class TopClass
{
    public function fetch($request){
        $external = $request->external;
        $subtype = $request->subtype;
        $year = $request->year;
        $laboratory = $request->laboratory;
        $top = $request->top;
        $count = $request->count;
        $sort = $request->sort;
        $individual = $request->individual;
        $classification = $request->classification;
        $month_name = $request->month;

        $startMonth = null;
        $endMonth = null;
        $month = null;
        if($request->by == 'By Month'){
            $month = ($request->month) ? \DateTime::createFromFormat('F', $request->month)->format('m') : null; 
            $by = 'Month';
        }elseif($request->by == 'By Quarter'){
            switch($request->quarter){
                case '1st Quarter':
                    $startMonth = 1;
                    $endMonth = 3;
                break;
                case '2nd Quarter':
                    $startMonth = 4;
                    $endMonth = 6;
                break;
                case '3rd Quarter':
                    $startMonth = 7;
                    $endMonth = 9;
                break;
                case '4th Quarter':
                    $startMonth = 10;
                    $endMonth = 12;
                break;
            }
            $by = 'Quarter';
        }elseif($request->by == 'By Semester'){
            switch($request->semester){
                case '1st Semester':
                    $startMonth = 1;
                    $endMonth = 6;
                break;
                case '2nd Semester':
                    $startMonth = 7;
                    $endMonth = 12;
                break;
            }
            $by = 'Semester';
        }else {
            $by = 'Month';
        }

        switch($top){
            case 'Top High-Request Customers':
                return $this->highRequest($top,$by,$year,$month,$startMonth,$endMonth,$sort,$classification,$individual,$count,$subtype,$month_name,$request->semester,$request->quarter, $external);
            break;
            case 'Top High-Spending Customers':
                return $this->highSpend($top,$by,$year,$month,$startMonth,$endMonth,$sort,$classification,$individual,$count,$subtype,$month_name,$request->semester,$request->quarter, $external);
            break;
        }
    }

    private function highSpend($top,$by,$year,$month,$startMonth,$endMonth,$sort,$classification,$individual,$count,$subtype,$month_name,$semester,$quarter, $external){
        $query = Customer::query();
        $query->select(
            'customers.id',
            'customers.name',
            'customers.is_main',
            'customers.name_id',
            'customers.agency_id',
            \DB::raw('SUM(tsr_payments.total) as total')
        )->with('customer_name:id,name,has_branches')
        ->join('tsrs', 'customers.id', '=', 'tsrs.customer_id')
        ->join('tsr_payments', 'tsrs.id', '=', 'tsr_payments.tsr_id')
        ->where('tsr_payments.status_id',7)
        ->when($classification, function ($q) use ($classification) {
            $q->whereHas('customer_name', function ($sub) use ($classification) {
                $sub->where('classification_id', $classification);
            });
        })
        ->when($external && $external !== 'All', function ($q) use ($external) {
            $q->where('is_internal', $external === 'External' ? 0 : 1);
        })
        ->groupBy(
            'customers.id',
            'customers.name',
            'customers.is_main',
            'customers.name_id',
            'customers.agency_id'
        )
        ->orderBy('total',$sort);
        \App\Services\Common\FacilityScope::apply($query);
        ($year) ? $query->whereYear('tsr_payments.paid_at', $year) : '';
        ($month) ? $query->whereMonth('tsr_payments.paid_at', $month) : '';
        $query->when(isset($startMonth) && isset($endMonth), function ($query) use ($startMonth, $endMonth) {
            $query->whereBetween(\DB::raw('MONTH(tsr_payments.paid_at)'), [$startMonth, $endMonth]);
        });
        // $data = $query->take(5)->get();
        // return[
        //     'data' => DefaultResource::collection($data),
        //     'total_tsrs' => Tsr::when($month, fn($q) => $q->whereMonth('created_at', $month))
        //         ->whereYear('created_at',$year)
        //         ->whereIn('status_id', [3,4])
        //         ->count()
        // ];

        if($subtype == 'print'){
            $data = $query->take($count)->get();
  
            $pdf = \PDF::loadView('tops.highspend', [
                'lists' => $data,
                'title' => $top,
                'year' => $year,
                'month' => $month_name,
                'semester' => $semester,
                'quarter' => $quarter,
                'external' =>  $external,
                'by' => $by,
                'classification' => ListDropdown::where('id',$classification)->value('name')
            ])->setPaper('a4', 'portrait');
            return $pdf->stream($month . '-' . $year . '.pdf');
        }else{
            $data = $query->paginate($count);
            return DefaultResource::collection($data)->additional([
                'total_tsrs' => Tsr::whereIn('status_id', [3,4])
                    ->whereHas('customer', function ($q) use ($classification, $external) {
                        $q->when($classification, function ($q) use ($classification) {
                            $q->whereHas('customer_name', function ($sub) use ($classification) {
                                $sub->where('classification_id', $classification);
                            });
                        });
                        $q->when($external && $external !== 'All', function ($q) use ($external) {
                            $q->where('is_internal', $external === 'External' ? 0 : 1);
                        });
                    })
                    ->when($month, fn($q) => $q->whereMonth('created_at', $month))
                    ->when($year, fn($q) => $q->whereYear('created_at', $year))
                    ->whereHas('payment', function ($q) {
                        $q->where('status_id', 7);
                    })
                    ->withSum(['payment as total_amount' => function ($q) {
                        $q->where('status_id', 7);
                    }], 'total')
                    ->get()
                    ->sum('total_amount')
            ]);
        }
    }

    private function highRequest($top,$by,$year,$month,$startMonth,$endMonth,$sort,$classification,$individual,$count,$subtype,$month_name,$semester,$quarter, $external){

        $query = Customer::query()->select('id','name','is_main','name_id','agency_id')->with('customer_name:id,name,has_branches')
        ->when($classification, function ($q) use ($classification) {
            $q->whereHas('customer_name', function ($sub) use ($classification) {
                $sub->where('classification_id', $classification);
            });
        })
        ->when($external && $external !== 'All', function ($q) use ($external) {
            $q->where('is_internal', $external === 'External' ? 0 : 1);
        });
        $query->withCount(['tsrs' => function ($query) use ($year,$month,$startMonth,$endMonth){
            $query->whereIn('status_id', [3,4]);
            ($year) ? $query->whereYear('created_at',$year) : '';
            ($month) ? $query->whereMonth('created_at',$month) : '';
            $query->when(isset($startMonth) && isset($endMonth), function ($query) use ($startMonth, $endMonth) {
                $query->whereBetween(\DB::raw('MONTH(created_at)'), [$startMonth, $endMonth]);
            });
        }]);
        

        if($subtype == 'print'){
            $data = $query->having('tsrs_count', '>', 0)->orderBy('tsrs_count', $sort)->take($count)->get();
  
            $pdf = \PDF::loadView('tops.highrequest', [
                'lists' => $data,
                'title' => $top,
                'year' => $year,
                'month' => $month_name,
                'semester' => $semester,
                'quarter' => $quarter,
                'external' =>  $external,
                'by' => $by,
                'classification' => ListDropdown::where('id',$classification)->value('name')
            ])->setPaper('a4', 'portrait');
            return $pdf->stream($month . '-' . $year . '.pdf');
        }else{
            $data = $query->having('tsrs_count', '>', 0)->orderBy('tsrs_count', $sort)->paginate($count);
            return DefaultResource::collection($data)->additional([
                'total_tsrs' => Tsr::when($month, fn($q) => $q->whereMonth('created_at', $month))
                    ->whereHas('customer', function ($q) use ($classification, $external) {
                        $q->when($classification, function ($q) use ($classification) {
                            $q->whereHas('customer_name', function ($sub) use ($classification) {
                                $sub->where('classification_id', $classification);
                            });
                        });
                        $q->when($external && $external !== 'All', function ($q) use ($external) {
                            $q->where('is_internal', $external === 'External' ? 0 : 1);
                        });
                    })
                    ->whereYear('created_at',$year)
                    ->whereIn('status_id', [3,4])
                    ->count()
            ]);
        }
    }
}
