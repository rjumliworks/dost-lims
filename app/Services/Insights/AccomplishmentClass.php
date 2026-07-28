<?php

namespace App\Services\Insights;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\ListLaboratory;
use App\Models\AgencyFacilityLaboratory;
use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Models\TsrSampleReport;
use App\Models\Target;
use App\Models\TargetBreakdown;
use App\Models\ListDiscount;
use App\Exports\PezaExport;
use Maatwebsite\Excel\Facades\Excel;

class AccomplishmentClass
{
    public function overall($request){
        $list = $request->list;

        $total = (int) $request->target;
        $count = count($list);

        if ($count === 0) {
            return [
                'message' => 'List is empty'
            ];
        }

        $base = intdiv($total, $count); // base value
        $remainder = $total % $count;   // extra to distribute

        foreach($list as $index => $l){
            $data = TargetBreakdown::findOrFail(is_array($l) ? $l['id'] : $l);

            // distribute remainder to first items
            $data->count = $base + ($index < $remainder ? 1 : 0);
            $data->save();
        }

        return [
            'message' => 'Target Set Successfully',
            'info' => "Target distributed without decimals."
        ];
    }

    public function target($request){
        $data = TargetBreakdown::findOrFail($request->id);
        $data->count = $request->target;
        $data->save();

        return [
            'data' => $data,
            'message' => 'Target Set Successfully', 
            'info' => "You've successfully created the new analysis."
        ];
    }

    public function accomplish($request){      
       
        $agencyId = \Auth::user()->profile?->agency_id;

        $type = $request->type;            
        $year = $request->year;                    
        $date = $request->date ? Carbon::parse($request->date) : Carbon::now();
        $month = $request->month  ? Carbon::parse($request->month)->month : Carbon::now()->month;
    

        $agency = AgencyFacilityLaboratory::whereHas('facility', function ($query) use ($agencyId){
            $query->where('agency_id',$agencyId);
        })->pluck('laboratory_id');  
        $laboratories = ListLaboratory::whereIn('id',$agency)->get();
        

        $lists = []; $requests_total = 0; $samples_total = 0; $analyses_total = 0; $fees_total = 0; $gratis_total = 0; $discount_total = 0; $gross_total = 0;
        
        foreach($laboratories as $laboratory){
            // === Requests ===
            $req = Tsr::where('status_id','!=',5)
                ->when($type === 'daily', function ($query) use ($date) {
                    $query->whereDate('created_at', $date);
                })
                ->when($type === 'monthly', function ($query) use ($month) {
                    $query->whereMonth('created_at', $month);
                })
                ->whereYear('created_at', $year)
                ->where('laboratory_id',$laboratory->id)
                ->count();

            // === Samples ===
            $sample = TsrSample::when($type === 'daily', function ($query) use ($date) {
                    $query->whereDate('created_at', $date);
                })
                ->when($type === 'monthly', function ($query) use ($month) {
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
                ->when($type === 'monthly', function ($query) use ($month) {
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
                ->when($type === 'monthly', fn($q) => $q->whereMonth('created_at', $month))
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
                ->when($type === 'monthly', fn($q) => $q->whereMonth('created_at', $month))
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
    
    public function assistanceBreakdown($request){
        $year = $request->year;
        $month = $request->month;

        $query = Tsr::withWhereHas('payment')
            ->where('status_id', '!=', 5)
            ->whereYear('created_at', $year);

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        $breakdown = $query->get()
            ->groupBy(fn ($tsr) => $tsr->payment->discount_id ?? 0)
            ->map(function ($group, $discountId) {
                $amount = $group->sum(function ($tsr) {
                    return (float) str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount);
                });

                return [
                    'discount_id' => $discountId,
                    'name' => optional(ListDiscount::find($discountId))->name ?? 'Unspecified',
                    'amount' => $amount,
                ];
            })
            ->sortByDesc('amount')
            ->values();

        return [
            'breakdown' => $breakdown,
            'total' => $breakdown->sum('amount'),
        ];
    }

    public function targets($request){
        $year = $request->year;
        $data = Target::with('breakdowns.laboratory','breakdowns.objective.type','breakdowns.items.item')->where('year',$year)->first();
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $breakdowns = $data->breakdowns;
        $grandtotal = 0;
        $grouped = $breakdowns->groupBy('objective_id')->map(function ($items) use ($months,$year,$grandtotal){
           
            $breakdown = []; $monthly = [];
            $monthly_all = [];
            foreach ($items as $item) {
                 $total = 0; 
                if($item->laboratory) {
                    $laboratory_id = $item->laboratory->id;
                    $monthly = [];
                    foreach($months as $index => $month){
                        $count = $this->count($item->objective->name,$index,$year,$month,$laboratory_id);
                        $total = $total + $count;
                        $monthly[] = [
                            'name' => $month,
                            'is_amount' => $items->first()['is_amount'],
                            'accomplish' => $count
                        ];

                        if (!isset($monthly_all[$index])) {
                            $monthly_all[$index] = [
                                'name' => $month,
                                'is_amount' => $items->first()['is_amount'],
                                'accomplish' => 0
                            ];
                        }
                        $monthly_all[$index]['accomplish'] += $count;
                    }
                    
                    $grandtotal =$grandtotal + $total;
                    $breakdown[] = [
                        'id' => $item->id,
                        'name' => $item->laboratory->name,
                        'target' => $item->count,
                        'months' => $monthly,
                        'accomplish' => $total,
                        'percentage' => ($item->count == 0) ? '-' : round(($total / $item->count) * 100, 2) . '%' 
                    ];
                }else{
                    $monthly = [];

                    foreach($months as $index => $month){

                        $count = $this->count($item->objective->name, null, $year, $month, null);

                        $total += $count;

                        $monthly[] = [
                            'name' => $month,
                            'is_amount' => $items->first()['is_amount'],
                            'accomplish' => $count
                        ];

                        if (!isset($monthly_all[$index])) {
                            $monthly_all[$index] = [
                                'name' => $month,
                                'is_amount' => $items->first()['is_amount'],
                                'accomplish' => 0
                            ];
                        }

                        $monthly_all[$index]['accomplish'] += $count;
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Sub Targets
                    |--------------------------------------------------------------------------
                    */

                    $subItems = [];

                    foreach ($item->items as $subItem) {

                        $subTotal = 0;
                        $subMonthly = [];

                        foreach ($months as $index => $month) {

                            $subCount = $this->subCount($item->objective->name,$subItem->item->name, $year, $month);

                            $subTotal += $subCount;

                            $subMonthly[] = [
                                'name' => $month,
                                'is_amount' => $items->first()['is_amount'],
                                'accomplish' => $subCount,
                            ];
                        }

                        $subItems[] = [
                            'id' => $subItem->id,
                            'name' => $subItem->item->name,
                            'target' => $subItem->count,
                            'months' => $subMonthly,
                            'accomplish' => $subTotal,
                            'percentage' => $subItem->count == 0
                                ? '-'
                                : round(($subTotal / $subItem->count) * 100, 2) . '%',
                        ];
                    }

                    $grandtotal += $total;

                    $breakdown = [
                        'id' => $item->id,
                        'name' => null,
                        'target' => $item->count,
                        'months' => $monthly,
                        'accomplish' => $total,
                        'percentage' => ($item->count == 0)
                            ? '-'
                            : round(($total / $item->count) * 100, 2) . '%',
                        'items' => $subItems,
                    ];
                }
            }
            $result = [
                'lists' => $items,
                'name' => $items->first()->objective->name,
                'target' => $items->sum('count'),
                'is_consolidated' => $items->first()['is_consolidated'],
                'is_amount' => $items->first()['is_amount'],
                'accomplish' => $grandtotal,
                'percentage' => ($items->sum('count') == 0) ? '-' : round(($grandtotal / $items->sum('count')) * 100, 2) . '%',
                'breakdown' => $breakdown,
                'monthly' => array_values($monthly_all),
                'objective_type' => $items->first()->objective->type->name,
                
            ];
            return $result;
        })->groupBy(fn ($item) => $item['objective_type']);
        return $grouped;
    }

    public function subCount($name,$subname,$year,$month){
        $months = [
            'Jan' => 1,
            'Feb' => 2,
            'Mar' => 3,
            'Apr' => 4,
            'May' => 5,
            'Jun' => 6,
            'Jul' => 7,
            'Aug' => 8,
            'Sep' => 9,
            'Oct' => 10,
            'Nov' => 11,
            'Dec' => 12,
        ];

         switch($name){
            case 'Number of MSMEs / LGUs / HEIs, communities and other customers assisted':
               
                if($subname == 'RSTL (Non-Paying)'){
                         $m = $months[$month] ?? null;
                    $count = Tsr::whereHas('payment', function ($query) {
                        $query->whereIn('discount_id',[5,7]);
                    })
                    ->whereHas('customer.customer_name', function ($query){
                        $query->where('classification_id',8);
                    })
                    ->whereMonth('created_at', $m)
                    ->whereYear('created_at', $year)
                    ->count();
                    return $count;

               }else{
                    return 0;
               }
            break;
            case 'Number of S&T Interventions Provided':
               if($subname == 'RSTL (Non-Paying)'){
                    $m = $months[$month] ?? null;
                 
                    $count = TsrAnalysis::whereHas('sample', function ($query) use ($m,$year){
                        $query->where('status_id','!=',13);
                        $query->whereHas('tsr', function ($query) use ($m,$year){
                            $query  ->whereHas('payment', function ($query) {
                                $query->whereIn('discount_id',[5,7]);
                            })
                            ->whereHas('customer.customer_name', function ($query){
                                $query->where('classification_id',8);
                            })
                            ->where('status_id','!=',5)
                            ->whereMonth('created_at',$m)
                            ->whereYear('created_at',$year);
                        });
                    })
                    ->count();

                    return $count;
                    
               }else{
                    return 0;
               }
            break;
        }
    }

    public function count($name,$index,$year,$month,$laboratory_id){
        $months = [
            'Jan' => 1,
            'Feb' => 2,
            'Mar' => 3,
            'Apr' => 4,
            'May' => 5,
            'Jun' => 6,
            'Jul' => 7,
            'Aug' => 8,
            'Sep' => 9,
            'Oct' => 10,
            'Nov' => 11,
            'Dec' => 12,
        ];

        switch($name){
            case 'Samples Received':
                $count = TsrSample::whereMonth('created_at',$index+1)->whereYear('created_at',$year)->whereHas('tsr', function ($query) use ($laboratory_id){
                    $query->where('laboratory_id',$laboratory_id)->where('status_id','!=',5);
                })->count();
            break;
            case 'Services Conducted':
                $count = TsrAnalysis::whereHas('sample', function ($query) use ($laboratory_id,$year,$index){
                    $query->where('status_id','!=',13);
                    $query->whereHas('tsr', function ($query) use ($laboratory_id,$year,$index){
                        $query->where('laboratory_id',$laboratory_id)->where('status_id','!=',5)->whereMonth('created_at',$index+1)->whereYear('created_at',$year);
                    });
                })
                ->count();
            break;
            case 'Customers Served':
                $count = Tsr::where('status_id','!=',5)->whereMonth('created_at',$index+1)->whereYear('created_at',$year)->where('laboratory_id',$laboratory_id)->count();
            break;
            case 'New Customers Served':
                $m = $months[$month] ?? null;
                // $count = Customer::query()
                // ->where('customers.is_new', true)
                // ->joinSub(
                //     \DB::table('tsrs')
                //         ->select('customer_id', \DB::raw('MIN(created_at) as first_tsr_date'))
                //         ->where('status_id', '!=', 5) // 🚫 exclude cancelled
                //         ->groupBy('customer_id'),
                //     'first_tsrs',
                //     'first_tsrs.customer_id',
                //     '=',
                //     'customers.id'
                // )
                // ->whereMonth('first_tsrs.first_tsr_date', $m)
                // ->whereYear('first_tsrs.first_tsr_date', $year)
                // ->count();
                $count = Tsr::query()
                ->where('is_first',1)
                ->where('status_id', '!=', 5) // 🚫 exclude cancelled
                ->whereMonth('created_at', $m)
                ->whereYear('created_at', $year)
                ->count();
            break;
            case 'Firms Served':
                $m = $months[$month] ?? null;
                $count = Tsr::whereIn('id', function ($query) use ($year,$month,$laboratory_id) {
                    $query->selectRaw('MIN(id)')
                        ->from('tsrs')
                        ->where('status_id','!=',5)
                        ->whereYear('created_at', $year)
                        ->groupBy('customer_id');
                })
                ->whereHas('customer.customer_name', function ($query) use ($m,$year){
                    $query->where('classification_id',8);
                })
                ->where('laboratory_id',$laboratory_id)
                ->whereMonth('created_at', $m)
                ->whereYear('created_at', $year)
                ->count();

            break;
            case 'Actual Fees Collected':
                $count = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free',0);
                })
                ->where('status_id','!=',5)
                ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                ->where('laboratory_id',$laboratory_id)
                ->get()
                ->sum(function ($tsr) {
                    return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->total);
                });
            break;
            case 'Values of Assistance Rendered':
                $discount = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free',0);
                })
                ->where('status_id','!=',5)
                ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                ->where('laboratory_id',$laboratory_id)
                ->get()
                ->sum(function ($tsr) {
                    return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount);
                });

                $gratis = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free',1);
                })
                ->where('status_id','!=',5)
                ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                ->where('laboratory_id',$laboratory_id)
                ->get()
                ->sum(function ($tsr) {
                    return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount);
                });

                $count = $gratis + $discount;
            break;
            case 'Paying Testing/Calibration Services Provided':
                $count = TsrAnalysis::whereHas('sample', function ($query) use ($laboratory_id,$index,$year){
                    $query->whereHas('tsr', function ($query) use ($laboratory_id,$index,$year){
                        $query->withWhereHas('payment', function ($query) {
                            $query->where('is_free',0);
                        });
                        $query->where('laboratory_id',$laboratory_id)->where('status_id','!=',5);
                        $query->whereMonth('created_at',$index+1)->whereYear('created_at',$year);
                    });
                })
                ->count();
            break;
            case 'Non-Paying Testing/Calibration Services Provided':
                $count = TsrAnalysis::whereHas('sample', function ($query) use ($laboratory_id,$index,$year){
                    $query->whereHas('tsr', function ($query) use ($laboratory_id,$index,$year){
                        $query->withWhereHas('payment', function ($query) {
                            $query->where('is_free',1);
                        });
                        $query->where('laboratory_id',$laboratory_id)->where('status_id','!=',5);
                        $query->whereMonth('created_at',$index+1)->whereYear('created_at',$year);
                    });
                })
                ->count();
            break;
            case 'Amount of Testing and Calibration Fees Collected':
                $amount = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free',0);
                })
                ->where('status_id','!=',5)
                ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                
                ->get()
                ->sum(function ($tsr) {
                    return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->total);
                });
                $discount = Tsr::whereDoesntHave('parent')
                ->withWhereHas('payment', function ($query) {
                    $query->where('is_free',0);
                })
                ->where('status_id','!=',5)
                ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                
                ->get()
                ->sum(function ($tsr) {
                    return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount);
                });

                $gratis = Tsr::withWhereHas('payment', function ($query) {
                    $query->where('is_free',1);
                })
                ->where('status_id','!=',5)
                ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                
                ->get()
                ->sum(function ($tsr) {
                    return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->discount);
                });

                $count = $gratis + $discount + $amount;

            break;
            case 'Ensure 99% of Test and Calibration Reports are ready on time':
                $count = 0;
            break;
            case 'Maintain 100% accuracy in all Test and Calibration Reports':
                $count = 0;
            break;
            case 'Firms Assisted':
                $i = 0;
                if($i == 0){
                    $count = Tsr::withWhereHas('payment', function ($query) {
                        $query->where('is_free',0);
                    })
                    ->whereHas('customer.customer_name', function ($query){
                         $query->where('classification_id',8);
                    })
                    ->where('status_id','!=',5)
                    ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                    ->where('laboratory_id',$laboratory_id)
                    ->get()
                    ->sum(function ($tsr) {
                        return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->total);
                    });
                }else{
                    $count = Tsr::withWhereHas('payment', function ($query) {
                        $query->where('is_free',0);
                    })
                    ->whereHas('customer.customer_name', function ($query){
                         $query->where('classification_id',8);
                    })
                    ->where('status_id','!=',5)
                    ->whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                    ->where('laboratory_id',$laboratory_id)
                    ->get()
                    ->sum(function ($tsr) {
                        return str_replace(['₱ ', '₱', ',', ' '], '', $tsr->payment->total);
                    });
                }
                $i++;
            break;
            case 'Number of Reports Generated ':
                $count = TsrSampleReport::whereMonth('created_at',$index+1)->whereYear('created_at',$year)
                ->whereHas('tsr', function ($query) use ($laboratory_id) {
                    $query->where('laboratory_id',$laboratory_id)->where('status_id','!=',5);
                })
                ->count();
            break;
            case 'Number of Firms Assisted':
                $m = $months[$month] ?? null;
                $count = Tsr::whereHas('customer', function ($query) use ($m,$year){
                    $query->whereMonth('created_at',$m)->whereYear('created_at',$year)
                    ->whereHas('customer_name', function ($q){
                        $q->where('classification_id',8);
                    });
                })
                ->where('laboratory_id',$laboratory_id)
                ->whereHas('payment', function ($query) {
                    $query->where('is_free', 1);
                })
                ->count();
            break;
            case 'Number of Samples Referred from PSTOs':
            case 'Number of Referred Samples Received from other Laboratories':
                // Determine the flag based on the current case
                $isPsto = ($name === 'Number of Samples Referred from PSTOs') ? 1 : 0;

                $count = TsrSample::whereMonth('created_at', $index + 1)
                    ->whereYear('created_at', $year)
                    ->whereHas('tsr', function ($query) use ($laboratory_id, $isPsto) {
                        $query->whereHas('referral', function ($query) use ($isPsto) {
                            $query->where('is_psto', $isPsto); // Use the dynamic flag
                        });
                        $query->where('laboratory_id', $laboratory_id)
                            ->where('status_id', '!=', 5)
                            ->where('is_referral', 1);
                    })->count();
                break;

            case 'Number of Services Referred from PSTOs':
            case 'Number of Referred Services Conducted from other Laboratories':
                // Determine the flag based on the current case
                $isPsto = ($name === 'Number of Services Referred from PSTOs') ? 1 : 0;

                $count = TsrAnalysis::whereHas('sample', function ($query) use ($laboratory_id, $year, $index, $isPsto) {
                        $query->where('status_id', '!=', 13);
                        $query->whereHas('tsr', function ($query) use ($laboratory_id, $year, $index, $isPsto) {
                            $query->whereHas('referral', function ($query) use ($isPsto) {
                                $query->where('is_psto', $isPsto); // Use the dynamic flag
                            });
                            $query->where('is_referral', 1)
                                ->where('laboratory_id', $laboratory_id)
                                ->where('status_id', '!=', 5)
                                ->whereMonth('created_at', $index + 1)
                                ->whereYear('created_at', $year);
                        });
                    })->count();
                break;
            default: 
            $count = 0;
        }
        return $count;
    }

     public function peza($request){
        $region = ($request->region) ? $request->region : null;
        $province = ($request->province) ? $request->province : null;
        $municipality = ($request->municipality) ? $request->municipality : null;
        $barangay = ($request->barangay) ? $request->barangay : null;

        return Excel::download(new PezaExport($region,$province,$municipality,$barangay), 'peza.xlsx');
    }

}
