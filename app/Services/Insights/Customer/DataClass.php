<?php

namespace App\Services\Insights\Customer;

use App\Models\Tsr;
use App\Models\Customer;
use App\Models\TsrPayment;
use App\Models\ListDropdown;
use App\Models\ListLaboratory;
use App\Models\LocationProvince;
use App\Models\LocationMunicipality;
use App\Http\Resources\DefaultResource;

class DataClass
{
  public function summary_count($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

        return [
            [
                'name' => 'New Customers',
                'description' => 'Customers who recently availed services',
                'total' => Customer::where('is_new',1)
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                })
                ->when($year, function ($query, $year) {
                    $query->whereYear('created_at',$year);
                })
                ->where('is_active',1)->count(),
                'icon' => 'ri-user-add-fill fs-20',
                'color' => 'text-info'
            ],
            [
                'name' => 'Active Customers',
                'description' => 'Customers actively using services',
                'total' => Customer::whereHas('tsrs', function ($query) use ($year, $month) {
                    ($year) ? $query->whereYear('created_at', $year) : '';
                    ($month) ? $query->whereMonth('created_at', $month) : '';
                })
                ->count(),
                'icon' => 'ri-group-2-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Old Customer',
                'description' => 'Existing customers who returned for services',
                'total' =>  Customer::whereYear('created_at', '<', $year) 
                ->whereHas('tsrs', function ($query) use ($year){
                    ($year) ? $query->whereYear('created_at', $year) : '';
                })
                ->count(),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-success',
                'icon' => 'ri-radio-button-fill fs-20',
                'color' => 'text-primary'
            ]
        ];
    }

    public function summary_type($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

        return [
            [
                'name' => 'Firms',
                'description' => 'Business entities availing services.',
                'total' => Customer::whereHas('customer_name', function ($q) {
                    $q->where('classification_id',8);
                })
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                })
                ->when($year, function ($query, $year) {
                    $query->whereYear('created_at',$year);
                })
                ->where('is_active',1)->count(),
                'icon' => 'ri-team-fill fs-20',
                'color' => 'text-dark'
            ],
            [
                'name' => 'Individuals',
                'description' => 'Private customers using services',
                'total' => Customer::whereHas('customer_name', function ($q) {
                    $q->where('classification_id',9);
                })
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                })
                ->when($year, function ($query, $year) {
                    $query->whereYear('created_at',$year);
                })
                ->where('is_active',1)->count(),
                'icon' => 'ri-user-3-fill fs-20',
                'color' => 'text-dark'
            ]
        ];
    }

    public function firms_industry($request){
         $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

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
        }

        $data = \DB::table('tsrs')
            ->join('customers', 'tsrs.customer_id', '=', 'customers.id')
            ->join('customer_names', 'customers.name_id', '=', 'customer_names.id') // ✅ required
            ->join('list_industries as industry', 'customer_names.industry_id', '=', 'industry.id')
            ->leftJoin('list_industries as type', 'industry.industry_id', '=', 'type.id')
            ->leftJoin('tsr_payments', function ($join) {
                $join->on('tsr_payments.tsr_id', '=', 'tsrs.id')
                    ->where('tsr_payments.status_id', 7);
            })
            ->select(
                \DB::raw("COALESCE(type.name, industry.name) as name"),
                \DB::raw('COUNT(DISTINCT tsrs.customer_id) as count'),
                \DB::raw('COALESCE(SUM(tsr_payments.total),0) as gross_sales')
            )
            ->where('customer_names.classification_id', 8) // ✅ FIXED
            ->where('tsrs.status_id','!=',5)
            ->tap(fn($query) => \App\Services\Common\FacilityScope::apply($query))
            ->when($laboratory, fn($q) => $q->where('tsrs.laboratory_id', $laboratory))
            ->when($year, fn($q) => $q->whereYear('tsrs.created_at', $year))
            ->when($month, fn($q) => $q->whereMonth('tsrs.created_at', $month))
            ->when(isset($startMonth) && isset($endMonth), function ($q) use ($startMonth, $endMonth) {
                $q->whereBetween(\DB::raw('MONTH(tsrs.created_at)'), [$startMonth, $endMonth]);
            })
            ->groupBy('name')
            ->orderBy('count','DESC')
            ->get();

        return $data;

    }

    public function firms_purpose($request){
         $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

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
        }

        $data = Tsr::select(
            'industry.name as name',
            \DB::raw('COUNT(CASE WHEN customers.is_new = 1 AND cn.classification_id = 8 THEN tsrs.id END) as new'),
            \DB::raw('COUNT(CASE WHEN cn.classification_id = 8 THEN tsrs.id END) as total')
        )
        ->join('customers', 'customers.id', '=', 'tsrs.customer_id')
        ->join('customer_names as cn', 'customers.name_id', '=', 'cn.id')
        ->join('list_industries as industry', 'cn.industry_id', '=', 'industry.id')
        ->when($year, fn($q) => $q->whereYear('tsrs.created_at', $year))
        ->when($month, fn($q) => $q->whereMonth('tsrs.created_at', $month))
        ->when(isset($startMonth) && isset($endMonth), function ($q) use ($startMonth, $endMonth) {
            $q->whereBetween(\DB::raw('MONTH(tsrs.created_at)'), [$startMonth, $endMonth]);
        })
        ->groupBy('industry.id', 'industry.name')
        ->orderBy('total', 'DESC')
        ->get();

        return $data;

    }

    public function firms_subindustry($request){
         $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

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
        }

        $data = \DB::table('tsrs')
            ->join('customers', 'tsrs.customer_id', '=', 'customers.id')
            ->join('customer_names as cn', 'customers.name_id', '=', 'cn.id') // ✅ NEW
            ->join('list_industries as industry', 'cn.industry_id', '=', 'industry.id') // ✅ FIXED
            ->select(
                'industry.name as name',
                \DB::raw('COUNT(DISTINCT tsrs.customer_id) as count')
            )
            ->where('cn.classification_id', 8) // ✅ FIXED
            ->where('tsrs.status_id','!=',5) // ✅ FIXED (avoid ambiguity)
            ->tap(fn($query) => \App\Services\Common\FacilityScope::apply($query))
            ->when($laboratory, fn($q) => $q->where('tsrs.laboratory_id', $laboratory))
            ->when($year, fn($q) => $q->whereYear('tsrs.created_at', $year))
            ->when($month, fn($q) => $q->whereMonth('tsrs.created_at', $month))
            ->when(isset($startMonth) && isset($endMonth), function ($q) use ($startMonth, $endMonth) {
                $q->whereBetween(\DB::raw('MONTH(tsrs.created_at)'), [$startMonth, $endMonth]);
            })
            ->groupBy('industry.name') // ✅ safer than alias
            ->orderBy('count','DESC')
            ->get();

        return $data;

    }

    public function customer_province($request){
        $year = $request->year;
        $month = $request->month;

        $provinces = Customer::with('address')
        // ->when($laboratory, function ($query, $laboratory) {
        //     $query->whereHas('tsrs', function ($q) use ($laboratory) {
        //         $q->where('laboratory_id', $laboratory); // Filter by laboratory_type
        //     });
        // })
        ->whereHas('address')
        ->when($year, function ($q) use ($year) {
            // Customer addresses are a single record, not versioned per year, so
            // membership for a given year must come from the customer's transactions.
            $q->whereHas('tsrs', function ($sub) use ($year) {
                $sub->whereYear('created_at', $year);
            });
        })
        ->get()
        ->pluck('address.province_code')
        ->unique();

        $municipalitiesData = LocationMunicipality::withCount(['address' => function ($query) use ($year) {
            $query->when($year, function ($q) use ($year) {
                $q->whereHas('customer.tsrs', function ($sub) use ($year) {
                    $sub->whereYear('created_at', $year);
                });
            });
            // $query->where('municipality_code', '097332000'); // Only count addresses with this municipality_code
        }])
        ->addSelect(['total_amount' => TsrPayment::selectRaw('COALESCE(SUM(tsr_payments.total),0)')
            ->join('tsrs', 'tsrs.id', '=', 'tsr_payments.tsr_id')
            ->join('customers', 'customers.id', '=', 'tsrs.customer_id')
            ->join('customer_addresses', 'customer_addresses.customer_id', '=', 'customers.id')
            ->whereColumn('customer_addresses.municipality_code', 'location_municipalities.code')
            ->where('tsr_payments.status_id', 7)
            ->when($year, fn($q) => $q->whereYear('tsr_payments.paid_at', $year))
        ])
        ->where('code', '097332000')
        ->orderBy('address_count', 'DESC')
        ->get();

        $provincesData = LocationProvince::withCount(['address' => function ($query) use ($year) {
            $query->where('municipality_code', '!=', '097332000')
                ->when($year, function ($q) use ($year) {
                    $q->whereHas('customer.tsrs', function ($sub) use ($year) {
                        $sub->whereYear('created_at', $year);
                    });
                });
        }])
        ->addSelect(['total_amount' => TsrPayment::selectRaw('COALESCE(SUM(tsr_payments.total),0)')
            ->join('tsrs', 'tsrs.id', '=', 'tsr_payments.tsr_id')
            ->join('customers', 'customers.id', '=', 'tsrs.customer_id')
            ->join('customer_addresses', 'customer_addresses.customer_id', '=', 'customers.id')
            ->where('customer_addresses.municipality_code', '!=', '097332000')
            ->whereColumn('customer_addresses.province_code', 'location_provinces.code')
            ->where('tsr_payments.status_id', 7)
            ->when($year, fn($q) => $q->whereYear('tsr_payments.paid_at', $year))
        ])
        ->whereIn('code', $provinces) // Filter by provinces
        ->orderBy('address_count', 'DESC') // Order by the number of addresses
        ->get();

        $combinedData = $municipalitiesData->merge($provincesData);
        return DefaultResource::collection($combinedData);
    }

    public function province($request){
        if($request->code){
            return $this->provinceCustomers($request);
        }
        return $this->customer_province($request);
    }

    public function provinceCustomers($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $laboratory = $request->laboratory;
        $classification = $request->classification;
        $code = $request->code;
        $count = $request->count ?: 10;
        $subtype = $request->subtype;

        $query = Customer::query()
            ->select('customers.id','customers.name','customers.is_main','customers.name_id','customers.agency_id')
            ->with(['customer_name:id,name,has_branches,classification_id', 'customer_name.classification:id,name'])
            ->whereHas('address', function ($q) use ($code) {
                ($code == '097332000') ? $q->where('municipality_code', $code) : $q->where('province_code', $code);
            })
            ->when($year, function ($q) use ($year) {
                // Customer addresses are a single record, not versioned per year, so
                // membership for a given year must come from the customer's transactions.
                $q->whereHas('tsrs', function ($sub) use ($year) {
                    $sub->whereYear('created_at', $year);
                });
            })
            ->when($classification, function ($q) use ($classification) {
                $q->whereHas('customer_name', function ($sub) use ($classification) {
                    $sub->where('classification_id', $classification);
                });
            })
            ->when($laboratory, function ($q) use ($laboratory) {
                $q->whereHas('tsrs', function ($sub) use ($laboratory) {
                    $sub->where('laboratory_id', $laboratory);
                });
            });

        $query->withCount(['tsrs' => function ($q) use ($year, $laboratory) {
            $q->whereIn('status_id', [3,4]);
            ($laboratory) ? $q->where('laboratory_id', $laboratory) : '';
            ($year) ? $q->whereYear('created_at', $year) : '';
        }]);

        $query->addSelect(['total_amount' => TsrPayment::selectRaw('COALESCE(SUM(tsr_payments.total),0)')
            ->join('tsrs', 'tsrs.id', '=', 'tsr_payments.tsr_id')
            ->whereColumn('tsrs.customer_id', 'customers.id')
            ->where('tsr_payments.status_id', 7)
            ->when($laboratory, fn($q) => $q->where('tsrs.laboratory_id', $laboratory))
            ->when($year, fn($q) => $q->whereYear('tsr_payments.paid_at', $year))
        ]);

        $query->orderBy('tsrs_count', $sort);

        $province = LocationMunicipality::where('code', $code)->value('name')
            ?? LocationProvince::where('code', $code)->value('name');

        if($subtype == 'print'){
            $data = $query->take($count)->get();

            $pdf = \PDF::loadView('tops.province', [
                'lists' => $data,
                'province' => $province,
                'year' => $year,
                'laboratory' => ListLaboratory::where('id', $laboratory)->value('name'),
                'classification' => ListDropdown::where('id', $classification)->value('name')
            ])->setPaper('a4', 'portrait');
            return $pdf->stream('province-'.$province.'-'.($year ?: 'all').'.pdf');
        }

        $data = $query->paginate($count);

        $totalRequests = Tsr::whereIn('status_id', [3,4])
            ->when($laboratory, fn($q) => $q->where('laboratory_id', $laboratory))
            ->when($year, fn($q) => $q->whereYear('created_at', $year))
            ->whereHas('customer', function ($q) use ($code, $classification) {
                $q->whereHas('address', function ($sub) use ($code) {
                    ($code == '097332000') ? $sub->where('municipality_code', $code) : $sub->where('province_code', $code);
                });
                $q->when($classification, function ($sub) use ($classification) {
                    $sub->whereHas('customer_name', function ($s) use ($classification) {
                        $s->where('classification_id', $classification);
                    });
                });
            })
            ->count();

        $totalAmount = TsrPayment::where('tsr_payments.status_id', 7)
            ->when($year, fn($q) => $q->whereYear('tsr_payments.paid_at', $year))
            ->whereHas('tsr', function ($q) use ($laboratory, $code, $classification) {
                ($laboratory) ? $q->where('laboratory_id', $laboratory) : '';
                $q->whereHas('customer', function ($sub) use ($code, $classification) {
                    $sub->whereHas('address', function ($a) use ($code) {
                        ($code == '097332000') ? $a->where('municipality_code', $code) : $a->where('province_code', $code);
                    });
                    $sub->when($classification, function ($c) use ($classification) {
                        $c->whereHas('customer_name', function ($cc) use ($classification) {
                            $cc->where('classification_id', $classification);
                        });
                    });
                });
            })
            ->sum('total');

        return DefaultResource::collection($data)->additional([
            'province' => $province,
            'total_requests' => $totalRequests,
            'total_amount' => $totalAmount,
        ]);
    }

    public function high_request($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

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
        }

        $query = Customer::query()->select('id','name','is_main','name_id','agency_id')->with('customer_name:id,name,has_branches');
        $query->withCount(['tsrs' => function ($query) use ($year,$month,$laboratory,$startMonth,$endMonth){
            $query->whereIn('status_id', [3,4]);
            ($laboratory) ? $query->where('laboratory_id',$laboratory) : '';
            ($year) ? $query->whereYear('created_at',$year) : '';
            ($month) ? $query->whereMonth('created_at',$month) : '';
            $query->when(isset($startMonth) && isset($endMonth), function ($query) use ($startMonth, $endMonth) {
                $query->whereBetween(\DB::raw('MONTH(created_at)'), [$startMonth, $endMonth]);
            });
        }]);
        $data = $query->having('tsrs_count', '>', 0)->orderBy('tsrs_count', $sort)->take(5)->get();
        return[
            'data' => DefaultResource::collection($data),
            'total_tsrs' => Tsr::when($month, fn($q) => $q->whereMonth('created_at', $month))
                ->whereYear('created_at',$year)
                ->whereIn('status_id', [3,4])
                ->count()
        ];
    }

    public function high_spend($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
        $month = $request->month;
        $laboratory = $request->laboratory;

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
        }

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
        ->groupBy(
            'customers.id',
            'customers.name',
            'customers.is_main',
            'customers.name_id',
            'customers.agency_id'
        )
        ->orderBy('total',$sort);
        \App\Services\Common\FacilityScope::apply($query);
        ($laboratory) ? $query->where('tsrs.laboratory_id', $laboratory) : '';
        ($year) ? $query->whereYear('tsr_payments.paid_at', $year) : '';
        ($month) ? $query->whereMonth('tsr_payments.paid_at', $month) : '';
        $query->when(isset($startMonth) && isset($endMonth), function ($query) use ($startMonth, $endMonth) {
            $query->whereBetween(\DB::raw('MONTH(tsr_payments.paid_at)'), [$startMonth, $endMonth]);
        });
        $data = $query->take(5)->get();
        return[
            'data' => DefaultResource::collection($data),
            'total_tsrs' => Tsr::when($month, fn($q) => $q->whereMonth('created_at', $month))
                ->whereYear('created_at',$year)
                ->whereIn('status_id', [3,4])
                ->count()
        ];
    }
}
