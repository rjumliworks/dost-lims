<?php

namespace App\Services\Dashboard;

use App\Models\Customer;
use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Models\TsrRelease;
use App\Models\TsrPayment;
use App\Models\TargetBreakdown;
use Carbon\Carbon;

class CroClass
{
    // public function __construct()
    // {
    //     $this->start = now()->copy()->startOfMonth()->format('Y-m-d');
    //     $this->end = now()->copy()->endOfMonth()->format('Y-m-d');
    // }
    
    public function dashboard($request){
        return [
            'counts' => $this->counts($request),
            'reminders' => $this->reminders($request),
            'statuses' => $this->statuses($request),
            'collection' => $this->collection($request),
            'collection_summary' => $this->collection_summary($request),
            'charts' => $this->charts($request),
            'fee' => $this->fees($request),
            'wallets' => $this->wallets($request),
            'target' => $this->target($request)
        ];
    }

    public function counts($request){
        return [
            // $this->ongoing($request),
            $this->tsrs($request),
            $this->samples($request),
            $this->testservices($request),
        ];
    }

    public function wallets($request)
    {
        return Customer::select('customers.id', 'customers.name', 'customers.name_id', 'customers.is_main')
            ->join('wallets', 'wallets.customer_id', '=', 'customers.id')
            ->with(['wallet', 'customer_name:id,name'])
            ->where('wallets.available', '>', 0)
            ->orderByDesc('wallets.available')
            ->get()
            ->map(function ($customer) {
                return [
                    'id' => $customer->reference,
                    'name' => $customer->fullname,
                    'available' => $customer->wallet->available,
                ];
            });
    }


    private function fees($request){
        $month = ($request->month) ? \DateTime::createFromFormat('F', $request->month)->format('m') : date('m');  
        $year = $request->year;
        $laboratory = $request->laboratory;

        $total = TsrPayment::where('paid_at','!=',NULL)->whereHas('tsr', function ($query) use ($month,$year,$laboratory){
            $query->when($month, function ($query) use ($month) {
                $query->whereMonth('created_at', $month);
            })
            ->when($laboratory, function ($query) use ($laboratory) {
                $query->where('laboratory_id', $laboratory);
            })
            ->whereYear('created_at',$year)->where('status_id','!=',5);
        })->sum('total');

        return $arr = [
            'name' => 'Actual Fees Collected',
            'icon' => 'ri-bank-card-fill',
            'color' => 'bg-info-subtle',
            'total' => $total
        ];
    }

   private function target($request)
{
    $year = $request->year ?? date('Y');
    $targetId = 2;

    $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    $currentMonthIndex = $request->month ? (int) \DateTime::createFromFormat('F', $request->month)->format('m') - 1 : date('m') - 1;

    // Get all consolidated breakdowns for this target and objective type
    $breakdowns = TargetBreakdown::with('objective')
        ->where('target_id', $targetId)
        ->whereHas('objective', fn($q) => $q->where('type_id', 76))
        ->get();

    $totalTarget = 0;
    $totalAccom = 0;

    foreach ($breakdowns as $item) {
        $objectiveName = $item->objective->name;
        $laboratoryId = $item->laboratory_id ?? null;

        $accom = 0;

        foreach ($months as $index => $month) {
            if ($index > $currentMonthIndex) break; // only up to selected month

            $accom += $this->count(
                $objectiveName,
                $laboratoryId ? $index : null,
                $year,
                $month,
                $laboratoryId
            );
        }

        $totalAccom += $accom;
        $totalTarget += $item->count;
    }

    $percentage = $totalTarget > 0 ? round(($totalAccom / $totalTarget) * 100, 2) : 0;

    return [
        'name' => 'OneLab KPI - Objective 1',
        'icon' => 'ri-bank-card-fill',
        'color' => 'bg-isuccess-subtle',
        'target' => $totalTarget,
        'accomplishment' => $totalAccom,
        'percentage' => $percentage . '%'
    ];
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
                $count = Customer::query()
                ->where('customers.is_new', true)
                ->joinSub(
                    \DB::table('tsrs')
                        ->select('customer_id', \DB::raw('MIN(created_at) as first_tsr_date'))
                        ->where('status_id', '!=', 5) // 🚫 exclude cancelled
                        ->groupBy('customer_id'),
                    'first_tsrs',
                    'first_tsrs.customer_id',
                    '=',
                    'customers.id'
                )
                ->whereMonth('first_tsrs.first_tsr_date', $m)
                ->whereYear('first_tsrs.first_tsr_date', $year)
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
            default: 
            $count = 0;
        }
        return $count;
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
            'icon' => 'ri-loader-2-line text-purple fs-24',
            'color' => 'bg-info-subtle',
            'series' => $series,
            'total' => Tsr::where('status_id',3)->count() //whereBetween('created_at',[$this->start,$this->end])->
        ];
    }

    private function tsrs($request){
        $year = $request->year;
        $monthInput = $request->month;
        $laboratory = $request->laboratory;

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
        ->when($laboratory, function ($query) use ($laboratory) {
            $query->where('laboratory_id', $laboratory);
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
            })
            ->when($laboratory, function ($query) use ($laboratory) {
                $query->where('laboratory_id', $laboratory);
            })
            ->whereYear('created_at',$year)->whereIn('status_id',[1,2,3,4])->count()
        ];
    }

    private function samples($request){
        $year = $request->year;
        $monthInput = $request->month;
        $laboratory = $request->laboratory;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $series = [];
        $data = TsrSample::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->whereHas('tsr', function ($query) use ($laboratory){
            $query->whereIn('status_id',[1,2,3,4])
            ->when($laboratory, function ($query) use ($laboratory) {
                $query->where('laboratory_id', $laboratory);
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
                })->whereYear('created_at', $year)->whereHas('tsr', function ($query) use ($laboratory){
                $query->whereIn('status_id',[1,2,3,4])
                ->when($laboratory, function ($query) use ($laboratory) {
                    $query->where('laboratory_id', $laboratory);
                });
            })->count()
        ];
    }

    private function testservices($request){
        $year = $request->year;
        $monthInput = $request->month;
        $laboratory = $request->laboratory;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $series = [];
        $data = TsrAnalysis::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
        ->whereHas('sample', function ($query) use ($laboratory){
            $query->whereHas('tsr', function ($query) use ($laboratory){
                $query->whereIn('status_id',[1,2,3,4])
                ->when($laboratory, function ($query) use ($laboratory) {
                    $query->where('laboratory_id', $laboratory);
                });
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
            'total' => TsrAnalysis::when($month, function ($query) use ($month,$laboratory) {
                    $query->whereMonth('created_at', $month);
                })->whereYear('created_at', $year)->whereHas('sample', function ($query) use ($laboratory){
                    $query->whereHas('tsr', function ($query) use ($laboratory){
                        $query->whereIn('status_id',[1,2,3,4])
                        ->when($laboratory, function ($query) use ($laboratory) {
                            $query->where('laboratory_id', $laboratory);
                        });
                    });
                })->count()
        ];
    }

    public function reminders($request){
        return [
            [
                'name' => 'Due Soon',
                'description' => '5 days ahead of the due date',
                'count' => Tsr::whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])->where('status_id','!=',4)->count(),
                'icon' => 'ri-error-warning-fill fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Overdue Request',
                'description' => 'Keep track of all laboratory tasks',
                'count' => Tsr::whereDate('due_at','<',now())->whereNotIn('status_id',[4,5])->count(),
                'icon' => 'ri-error-warning-fill fs-20',
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

    public function collection($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
         $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $laboratory = $request->laboratory;

        return [
            [
                'name' => 'Collected Amount (Receipted)',
                'description' => 'Successfully collected and receipted',
                // 'description' => ' Total amount successfully collected and receipted',
                'total' => (function () use ($laboratory, $month, $year) {
                    $total = TsrPayment::whereHas('tsr', function ($query) use ($laboratory, $month, $year) {
                            $query->where('status_id', '!=', 5);
                            $query->when($laboratory, function ($query, $laboratory) {
                                $query->where('laboratory_id', $laboratory);
                            });
                            if ($year) {
                                $query->whereYear('created_at', $year);
                            }
                            if ($month) {
                                $query->whereMonth('created_at', $month);
                            }
                        })
                        ->where('status_id', 7)
                        ->where('is_paid', 1)
                        ->where('is_child', 0)
                        ->sum('total');

                    // ✅ Add manual values for 2024 (Jan–Sep)
                    if ($year == 2024) {
                        $manualCollected = [
                            540853.4, // Jan
                            331486,   // Feb
                            778483.6, // Mar
                            621516.8, // Apr (note: you said 621,516.8, not 612,516.8)
                            708506,   // May
                            383944,   // Jun
                            580560,   // Jul
                            427169,   // Aug
                            116860,   // Sep
                        ];

                        // ✅ If a specific month is selected → only add that month’s value
                        if ($month && $month >= 1 && $month <= 9) {
                            $total += $manualCollected[$month - 1];
                        } 
                        // ✅ If NO specific month → add all Jan–Sep manually
                        elseif (!$month) {
                            $total += array_sum($manualCollected);
                        }
                    }

                    return $total;
                })(),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Uncollected Amount',
                'description' => 'Pending payments not yet received',
                // 'description' => 'Total pending payments not yet received',
                'total' => (function () use ($laboratory, $year, $month) {
                    $total = TsrPayment::whereHas('tsr', function ($query) use ($laboratory, $year, $month) {
                            $query->where('status_id', '!=', 5);
                            $query->when($laboratory, function ($query, $laboratory) {
                                $query->where('laboratory_id', $laboratory);
                            });
                            if ($year) {
                                $query->whereYear('created_at', $year);
                            }
                            if ($month) {
                                $query->whereMonth('created_at', $month);
                            }
                        })
                        ->whereIn('status_id', [6, 18])
                        ->where('is_paid', 0)
                        ->where('is_child', 0)
                        ->sum('total');

                    // ✅ Add manual ₱9,320 for year 2024
                    if ($year == 2024) {
                        $total += 9320;
                    }

                    return $total;
                })(),
                'icon' => 'ri-close-circle-fill fs-20',
                'color' => 'text-danger'
            ],
            [
                'name' => 'Total Transaction Value',
                'description' => 'Total monetary value of all transactions',
                'total' => TsrPayment::whereHas('tsr', function ($query) use ($laboratory,$year,$month){
                    $query->where('status_id','!=',5);
                    $query->when($laboratory, function ($query, $laboratory) {
                        $query->where('laboratory_id',$laboratory);
                    });
                    ($year) ? $query->whereYear('created_at',$year) : '';
                    ($month) ? $query->whereMonth('created_at',$month) : '';
                })->whereIn('status_id',[6,7,18])->where('is_child',0)->sum('total'),
                'icon' => 'ri-radio-button-fill fs-20',
                'color' => 'text-primary'
            ]
        ];
    }

    public function collection_summary($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = $request->year;
         $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = null; 
        } else {
            $month = date('m', strtotime($monthInput));
        }
        $laboratory = $request->laboratory;

        return [
            [
                'name' => 'Complimentary Service Amount',
                // 'description' => 'Total value of services provided free of charge.',
                'description' => 'Value of services free of charge',
                'total' => TsrPayment::whereHas('tsr', function ($query) use ($laboratory,$year,$month){
                    $query->where('status_id','!=',5);
                    $query->when($laboratory, function ($query, $laboratory) {
                        $query->where('laboratory_id',$laboratory);
                    });
                    ($year) ? $query->whereYear('created_at',$year) : '';
                    ($month) ? $query->whereMonth('created_at',$month) : '';
                })->where('status_id',8)->where('is_free',1)->where('is_child',0)->sum('discount'),
                'icon' => 'ri-hearts-fill fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'Aggregate Collection Value',
                'description' => 'Collected, Paid & Complimentary',
                // 'description' => 'Total collected, payments and complimentary services.',
                'total' => TsrPayment::whereHas('tsr', function ($query) use ($laboratory,$year,$month) {
                    $query->where('status_id','!=',5);
                    $query->when($laboratory, function ($query, $laboratory) {
                        $query->where('laboratory_id',$laboratory);
                    });
                    ($year) ? $query->whereYear('created_at',$year) : '';
                    ($month) ? $query->whereMonth('created_at',$month) : '';
                })->whereIn('status_id',[6,7,18])->where('is_child',0)->sum('total') + TsrPayment::whereHas('tsr', function ($query) use ($laboratory,$year,$month){
                    $query->where('status_id','!=',5);
                    $query->when($laboratory, function ($query, $laboratory) {
                        $query->where('laboratory_id',$laboratory);
                    });
                    ($year) ? $query->whereYear('created_at',$year) : '';
                    ($month) ? $query->whereMonth('created_at',$month) : '';
                })->where('status_id',8)->where('is_free',1)->where('is_child',0)->sum('discount'),
                'icon' => 'ri-medal-fill fs-20',
                'color' => 'text-info'
            ]
        ];
    }

    public function statuses($request)
    {
        $month = $request->month
            ? Carbon::createFromFormat('F', $request->month)->month
            : null;

        $year = $request->year;
        $laboratory = $request->laboratory;

        // TSR Counts (1 query)
        $yearCounts = Tsr::query()
            ->whereYear('created_at', $year)
            ->when($laboratory, fn ($q) => $q->where('laboratory_id', $laboratory))
            ->selectRaw('status_id, COUNT(*) as total')
            ->groupBy('status_id')
            ->pluck('total', 'status_id');

        // TSR Counts filtered by month/year (1 query)
        $filteredCounts = Tsr::query()
            ->whereYear('created_at', $year)
            ->when($month, fn ($q) => $q->whereMonth('created_at', $month))
            ->when($laboratory, fn ($q) => $q->where('laboratory_id', $laboratory))
            ->selectRaw('status_id, COUNT(*) as total')
            ->groupBy('status_id')
            ->pluck('total', 'status_id');

        // MOA Counts
        $moaCount = TsrPayment::query()
            ->where('status_id', 18)
            ->where('is_paid', 0)
            ->whereHas('tsr', function ($query) use ($year, $month, $laboratory) {
                $query->whereYear('created_at', $year)
                ->when($month, fn ($q) => $q->whereMonth('created_at', $month))
                ->when($laboratory, fn ($q) => $q->where('laboratory_id', $laboratory));
            })
            ->count();

        $moaYearCount = TsrPayment::query()
            ->where('status_id', 18)
            ->where('is_paid', 0)
            ->whereHas('tsr', function ($query) use ($year,$laboratory) {
                $query->whereYear('created_at', $year)->when($laboratory, fn ($q) => $q->where('laboratory_id', $laboratory));
            })
            ->count();

        $percentage = function ($count, $yearCount) {
            return $yearCount > 0
                ? round(($count / $yearCount) * 100, 1)
                : 0;
        };
        
        $total = Tsr::whereIn('status_id',[1,2,3,4])->whereYear('created_at', $year)->count();

        return [
            [
                'name' => 'Pending',
                'description' => 'Requests awaiting review',
                'count' => $filteredCounts[1] ?? 0,
                'year_count' => $yearCounts[1] ?? 0,
                'percentage' => $percentage(
                    $filteredCounts[1] ?? 0,
                    $yearCounts[1] ?? 0
                ),
                'total' => $total,
                'icon' => 'bx bx-error fs-20',
                'color' => 'text-warning'
            ],
            [
                'name' => 'For Payment',
                'description' => 'Awaiting payment confirmation',
                'count' => $filteredCounts[2] ?? 0,
                'year_count' => $yearCounts[2] ?? 0,
                'percentage' => $percentage(
                    $filteredCounts[2] ?? 0,
                    $yearCounts[2] ?? 0
                ),
                'total' => $total,
                'icon' => 'bx bx-error-circle fs-20',
                'color' => 'text-dark'
            ],
            [
                'name' => 'Memorandum of Agreement',
                'description' => 'Requests with approved MOA',
                'count' => $moaCount,
                'year_count' => $moaYearCount,
                'percentage' => $percentage(
                    $moaCount,
                    $moaYearCount
                ),
                'total' => $total,
                'icon' => 'ri-error-warning-line fs-20',
                'color' => 'text-danger'
            ],
            [
                'name' => 'Ongoing Request',
                'description' => 'Currently in progress',
                'count' => $filteredCounts[3] ?? 0,
                'year_count' => $yearCounts[3] ?? 0,
                'percentage' => $percentage(
                    $filteredCounts[3] ?? 0,
                    $yearCounts[3] ?? 0
                ),
                'total' => $total,
                'icon' => 'ri-loader-2-line fs-20',
                'color' => 'text-purple'
            ],
            [
                'name' => 'Completed Request',
                'description' => 'Successfully completed',
                'count' => $filteredCounts[4] ?? 0,
                'year_count' => $yearCounts[4] ?? 0,
                'percentage' => $percentage(
                    $filteredCounts[4] ?? 0,
                    $yearCounts[4] ?? 0
                ),
                'total' => $total,
                'icon' => 'ri-checkbox-circle-line fs-20',
                'color' => 'text-success'
            ]
        ];
    }


    public function charts($request){
        $year = $request->year ?? date('Y');
        $laboratory = $request->laboratory;

        $monthInput = $request->month;

        // ✅ Handle month safely
        if (is_null($monthInput)) {
            $month = date('m'); // default to current month
        } else {
            $month = date('m', strtotime($monthInput));
        }

        $start = Carbon::create($year, $month, 1);
        $end = Carbon::create($year, $month, 1)->endOfMonth();

        $categories = [];
        $first = [];
        $second = [];
        $third = [];

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {

            // ✅ Skip weekends (Saturday & Sunday)
            if ($date->isWeekend()) {
                continue;
            }

            $categories[] = $date->format('d'); // or 'M d' / 'D d'

            $collected = Tsr::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
            ->whereIn('status_id',[1,2,3,4]) //status is completed
            // ->whereBetween('created_at', [$this->start, $this->end])
            ->whereDate('created_at', $date)
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy(\DB::raw('DATE(created_at)'))
            ->count();

            $first[] = $collected;

            // ✅ UNCOLLECTED
            $uncollected = TsrSample::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
            ->whereHas('tsr', function ($query){
                $query->whereIn('status_id',[1,2,3,4]);
            })
            // ->whereBetween('created_at', [$this->start, $this->end])
            ->whereDate('created_at', $date)
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy(\DB::raw('DATE(created_at)'))
            ->count();

            $second[] = $uncollected;

            $free = TsrAnalysis::select(\DB::raw('DATE(created_at) AS x'), \DB::raw('count(*) AS y'))
            ->whereHas('sample', function ($query){
                $query->whereHas('tsr', function ($query){
                    $query->whereIn('status_id',[1,2,3,4]);
                });
            })
            // ->whereBetween('created_at', [$this->start, $this->end])
            ->whereDate('created_at', $date)
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->orderBy(\DB::raw('DATE(created_at)'))
            ->count();
            
            $third[] = $free;
        }

        return [
            'categories' => $categories,
            'lists' => [
                [
                    'name' => 'Customer Served',
                    'data' => $first
                ],
                [
                    'name' => 'Samples Received', 
                    'data' => $second
                ],
                [
                    'name' => 'Services Conducted', 
                    'data' => $third
                ]
            ]
        ];
    }
}
