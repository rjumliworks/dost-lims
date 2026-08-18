<?php

namespace App\Services\Insights\Performance;

use Carbon\Carbon;
use App\Models\ListLaboratory;
use App\Models\AgencyFacilityLaboratory;
use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Models\Customer;
use App\Exports\Excel\PerformanceTopExport;

class ViewClass
{
    public function accomplish($request){      
       
        // $agencyId = \Auth::user()->profile?->agency_id;

        $type = $request->type;            
        $year = $request->year;                    
        $date = $request->date ? Carbon::parse($request->date) : Carbon::now();
        $month = $request->month ? Carbon::parse($request->month)->month : null;
    

        // $agency = AgencyFacilityLaboratory::whereHas('facility', function ($query) use ($agencyId){
        //     $query->where('agency_id',$agencyId);
        // })->pluck('laboratory_id');  
        $laboratories = ListLaboratory::get();
        

        $lists = []; $requests_total = 0; $samples_total = 0; $analyses_total = 0; $fees_total = 0; $gratis_total = 0; $discount_total = 0; $gross_total = 0;
        
        foreach($laboratories as $laboratory){
            // === Requests ===
            $req = Tsr::where('status_id','!=',5)
                ->when($type === 'daily', function ($query) use ($date) {
                    $query->whereDate('created_at', $date);
                })
                ->when($type === 'monthly' && $month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })
                ->whereYear('created_at', $year)
                ->where('laboratory_id',$laboratory->id)
                ->count();

            // === Samples ===
            $sample = TsrSample::when($type === 'daily', function ($query) use ($date) {
                    $query->whereDate('created_at', $date);
                })
                ->when($type === 'monthly' && $month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })
                ->whereYear('created_at', $year)
                ->whereHas('tsr', function ($query) use ($laboratory){
                    $query->where('laboratory_id',$laboratory->id)
                        ->where('status_id','!=',5);
                })
                ->count();

            // === Analyses ===
            $analysis = TsrAnalysis::when($type === 'daily', function ($query) use ($date) {
                    $query->whereDate('created_at', $date);
                })
                ->when($type === 'monthly' && $month, function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })
                ->whereYear('created_at', $year)
                ->whereHas('sample', function ($query) use ($laboratory){
                    $query->whereHas('tsr', function ($query) use ($laboratory){
                        $query->where('laboratory_id',$laboratory->id)
                            ->where('status_id','!=',5);
                    });
                })
                ->count();

            // === Fees / Payments ===
            $basePaymentQuery = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free', 0);
                })
                ->where('status_id','!=',5)
                ->where('laboratory_id',$laboratory->id)
                ->when($type === 'daily', fn($q) => $q->whereDate('created_at', $date))
                ->when($type === 'monthly' && $month, fn($q) => $q->whereMonth('created_at', $month))
                ->whereYear('created_at', $year);

            $gtotal = $basePaymentQuery->get()->sum(function ($tsr) {
                return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->total);
            });

            $gdiscount = $basePaymentQuery->get()->sum(function ($tsr) {
                return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount);
            });

            $ggratis = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free', 1);
                })
                ->where('status_id','!=',5)
                ->where('laboratory_id',$laboratory->id)
                ->when($type === 'daily', fn($q) => $q->whereDate('created_at', $date))
                ->when($type === 'monthly' && $month, fn($q) => $q->whereMonth('created_at', $month))
                ->whereYear('created_at', $year)
                ->get()
                ->sum(function ($tsr) {
                    return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount);
                });

            // === Build list row ===
            $lists[] = [
                $laboratory->short,
                $req,
                $sample,
                $analysis,
                '₱'.number_format($gtotal),
                '₱'.number_format($ggratis),
                '₱'.number_format($gdiscount),
                '₱'.number_format($gtotal + $ggratis + $gdiscount),
                $laboratory->id,
            ];

            // === Totals ===
            $requests_total += $req;
            $samples_total += $sample;
            $analyses_total += $analysis;
            $fees_total += $gtotal;
            $gratis_total += $ggratis;
            $discount_total += $gdiscount;
            $gross_total += ($gtotal + $ggratis + $gdiscount);
        }
        $footer[] = [
            'Total',$requests_total, $samples_total, $analyses_total, '₱'.number_format($fees_total), '₱'.number_format($gratis_total), '₱'.number_format($discount_total), '₱'.number_format($gross_total)
        ];
        return [
            'lists' => $lists,
            'footer' => $footer
        ];
    }

    public function totalsamples()
    {
        $data = TsrSample::whereHas('tsr',function ($query){
            $query->where('status_id','!=',5);
        })
        ->where('samplename_id','!=',1)
        ->whereYear('created_at',now())->count();
        return $data;
    }

    public function totaloldsamples()
    {
        $data = TsrSample::whereHas('tsr',function ($query){
            $query->where('status_id','!=',5);
        })
        ->where('samplename_id',1)
        ->whereYear('created_at',now())->count();
        return $data;
    }

    public function samples($request, $limit = 500){
        $startMonth = null;
        $endMonth = null;
        $month = null;
        if($request->by == 'By Month'){
            $month = ($request->month) ? \DateTime::createFromFormat('F', $request->month)->format('m') : null; 
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
        }else{
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
        }

        $data = TsrSample::join('sample_names', 'sample_names.id', '=', 'tsr_samples.samplename_id')
        ->select('sample_names.name as name', \DB::raw('count(*) as count'))
        ->where('tsr_samples.samplename_id', '!=', 1)
        ->withWhereHas('tsr',function ($query) use ($request){
            $query->when($request->laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id',$laboratory);
            });
            $query->whereHas('customer',function ($query) use ($request){
                $query ->when($request->customer, function ($query, $customer) {
                   ($customer == 'Internal') ? $query->where('is_internal',1) : $query->where('is_internal',0);
                });
            });
        })
        ->when($month, function ($query, $month) {
            $query->whereMonth('tsr_samples.created_at',$month);
        })
        ->when($request->year, function ($query, $year) {
            $query->whereYear('tsr_samples.created_at',$year);
        })
        ->when(isset($startMonth) && isset($endMonth), function ($query) use ($startMonth, $endMonth) {
            $query->whereBetween(\DB::raw('MONTH(tsr_samples.created_at)'), [$startMonth, $endMonth]);
        })
        ->groupBy('sample_names.id', 'sample_names.name')
        ->orderBy('count', 'desc')
        ->when($limit, function ($query, $limit) {
            $query->take($limit);
        })
        ->get();
        return $data;
    }

    // Legacy TsrSample rows recorded before samplename_id existed were backfilled to
    // samplename_id = 1 ("n/a"), so they can't be grouped via sample_names and instead
    // fall back to the old free-text name column.
    public function old_samples($request, $limit = 500){
        $startMonth = null;
        $endMonth = null;
        $month = null;
        if($request->by == 'By Month'){
            $month = ($request->month) ? \DateTime::createFromFormat('F', $request->month)->format('m') : null; 
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
        }else{
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
        }

        $data = TsrSample::select('name', \DB::raw('count(*) as count'))
        ->where('samplename_id', 1)
        ->withWhereHas('tsr',function ($query) use ($request){
            $query->when($request->laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id',$laboratory);
            });
            $query->whereHas('customer',function ($query) use ($request){
                $query ->when($request->customer, function ($query, $customer) {
                   ($customer == 'Internal') ? $query->where('is_internal',1) : $query->where('is_internal',0);
                });
            });
        })
        ->when($month, function ($query, $month) {
            $query->whereMonth('created_at',$month);
        })
        ->when($request->year, function ($query, $year) {
            $query->whereYear('created_at',$year);
        })
        ->when(isset($startMonth) && isset($endMonth), function ($query) use ($startMonth, $endMonth) {
            $query->whereBetween(\DB::raw('MONTH(created_at)'), [$startMonth, $endMonth]);
        })
        ->groupBy('name')
        ->orderBy('count', 'desc')
        ->when($limit, function ($query, $limit) {
            $query->take($limit);
        })
        ->get();
        return $data;
    }

    public function analyses($request, $limit = 300){
        $startMonth = null;
        $endMonth = null;
        $month = null;
        if($request->by == 'By Month'){
            $month = ($request->month) ? \DateTime::createFromFormat('F', $request->month)->format('m') : null; 
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
        }else{
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
        }

        $query = \DB::table('tsr_analyses')
        ->join('testservices', 'testservices.id', '=', 'tsr_analyses.testservice_id')
        ->join('testservice_names', 'testservice_names.id', '=', 'testservices.testname_id')
        ->join('tsr_samples', 'tsr_samples.id', '=', 'tsr_analyses.sample_id')
        ->join('tsrs', 'tsrs.id', '=', 'tsr_samples.tsr_id')
        ->join('customers', 'customers.id', '=', 'tsrs.customer_id')
        ->select('testservice_names.name as name', \DB::raw('COUNT(*) as count'))
        ->where('tsr_analyses.status_id', '!=', 13);

        \App\Services\Common\FacilityScope::apply($query);

        $data = $query
        ->when($month, fn($q) => $q->whereMonth('tsr_analyses.created_at', $month))
        ->when($request->year, fn($q) => $q->whereYear('tsr_analyses.created_at', $request->year))
        ->when(isset($startMonth) && isset($endMonth), fn($q) => 
            $q->whereBetween(\DB::raw('MONTH(tsr_analyses.created_at)'), [$startMonth, $endMonth])
        )
        ->when($request->laboratory, fn($q, $lab) => $q->where('tsrs.laboratory_id', $lab))
        ->when($request->customer, function ($q, $customer) {
            if ($customer === 'Internal') {
                $q->where('customers.is_internal', 1);
            } else {
                $q->where('customers.is_internal', 0);
            }
        })
        ->groupBy('testservice_names.name')
        ->orderByDesc('count')
        ->when($limit, function ($query, $limit) {
            $query->limit($limit);
        })
        ->get();
        return $data;
    }

    public function customers($request, $limit = 500){
        $startMonth = null;
        $endMonth = null;
        $month = null;
        if($request->by == 'By Month'){
            $month = ($request->month) ? \DateTime::createFromFormat('F', $request->month)->format('m') : null; 
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
        }else{
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
        }

        $year = $request->year;
        $laboratory = $request->laboratory;

        $data = Customer::select('id', 'name', 'is_main', 'name_id', 'agency_id')
        ->with('customer_name:id,name,has_branches')
        // ->where('agency_id', $this->agency)
        ->withCount(['tsrs' => function ($query) use ($year, $month, $startMonth, $endMonth, $laboratory, $request) {
            $query->whereIn('status_id', [3, 4]);

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            if ($month) {
                $query->whereMonth('created_at', $month);
            }

            if (isset($startMonth) && isset($endMonth)) {
                $query->whereBetween(\DB::raw('MONTH(created_at)'), [$startMonth, $endMonth]);
            }

            $query->when($laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id', $laboratory);
            });

            $query->whereHas('customer', function ($query) use ($request) {
                $query->when($request->customer, function ($query, $customer) {
                    $query->where('is_internal', $customer == 'Internal' ? 1 : 0);
                });
            });
        }])
        ->having('tsrs_count', '>', 0) // ✅ Only include customers with at least 1 tsr
        ->orderBy('tsrs_count', 'desc')
        ->when($limit, function ($query, $limit) {
            $query->take($limit);
        })
        ->get();
        return $data;
    }

    protected function exportData($request){
        switch($request->type){
            case 'samples_old':
                $title = 'Top Samples (Old)';
                $rows = $this->old_samples($request, null)->map(function ($item) {
                    return ['name' => $item->name, 'count' => $item->count];
                });
            break;
            case 'samples_new':
                $title = 'Top Samples (New)';
                $rows = $this->samples($request, null)->map(function ($item) {
                    return ['name' => $item->name, 'count' => $item->count];
                });
            break;
            case 'analyses':
                $title = 'Top Analysis';
                $rows = $this->analyses($request, null)->map(function ($item) {
                    return ['name' => $item->name, 'count' => $item->count];
                });
            break;
            case 'customers':
                $title = 'Top Customer Served';
                $rows = $this->customers($request, null)->map(function ($item) {
                    $suffix = ($item->name == 'Main') ? '' : ' - '.$item->name;
                    return ['name' => $item->customer_name->name.$suffix, 'count' => $item->tsrs_count];
                });
            break;
            default:
                $title = 'Top List';
                $rows = collect();
            break;
        }

        return [
            'title' => $title,
            'rows' => $rows->values()
        ];
    }

    public function excel($request){
        $export = $this->exportData($request);

        return \Excel::download(new PerformanceTopExport($export['rows'], $export['title']), $request->type.'.xlsx');
    }

    public function print($request){
        $export = $this->exportData($request);

        $pdf = \PDF::loadView('reports.performance-top', $export)->setPaper('a4', 'portrait');
        return $pdf->stream($request->type.'.pdf');
    }
}
