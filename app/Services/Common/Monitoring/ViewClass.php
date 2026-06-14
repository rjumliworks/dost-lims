<?php

namespace App\Services\Common\Monitoring;

use Carbon\Carbon;
use App\Models\Tsr;
use App\Models\TsrSample;
use App\Models\TsrAnalysis;
use App\Http\Resources\Major\Tsr\MonitoringResource;

class ViewClass
{
    public function dashboard($request, $laboratories){
        return [
            'laboratories' => $this->laboratories($laboratories,$request),
            'release' => $this->release($request),
            'moa' => $this->moa($request),
            'counts' => $this->counts($request),
            'dues' => $this->dues($request),
            'alerts' => $this->alerts($laboratories,$request),
        ];
    }

    
    public function laboratories($laboratories,$request){
        $year = $request->year;
        $month = $request->month ? Carbon::parse($request->month)->month : null;

        return $laboratories->map(function ($lab) use ($year,$month) {
            $overall = Tsr::where('laboratory_id', $lab['value'])
                ->whereIn('status_id', [3,4])
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                }) 
                ->whereYear('created_at', $year)
                ->count();

            $ongoing = Tsr::where('laboratory_id', $lab['value'])
                ->where('status_id', 3)
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at',$month);
                }) 
                ->whereYear('created_at', $year)
                ->count();

            $percentage = $overall > 0
                ? round(($ongoing / $overall) * 100, 2)
                : 0;
            return [
                'id' => $lab['value'],
                'name' => $lab['name'],
                'overall' => $overall,
                'ongoing' => $ongoing,
                'percentage' => $percentage,
            ];
        });
    }

    public function list($request){
        $month = $request->month ? Carbon::parse($request->month)->month : null;

        $data = MonitoringResource::collection(
            Tsr::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('laboratory:id,name','status:id,name,color,others')
            ->with('payment:tsr_id,id,total,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('code', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('customer', function ($q) use ($keyword) {
                        $q->join('customer_names', 'customers.name_id', '=', 'customer_names.id')
                        ->whereRaw("
                            CASE
                                WHEN customers.is_main = 1 THEN customer_names.name
                                ELSE CONCAT(customer_names.name, ' - ', customers.name)
                            END LIKE ?
                        ", ["%{$keyword}%"]);
                        });
                    });
            })
            ->with(['samples' => function ($query){
                $query->select('id','tsr_id');
                $query->withCount([
                    'analyses as analyses_count',
                    'analyses as completed_analyses_count' => function ($query) {
                        $query->where('status_id', 12);
                    },
                    'analyses as ongoing_analyses_count' => function ($query) {
                        $query->where('status_id', 11);
                    }
                ]);
                $query->withExists('report');
            }])
            ->when($request->datetype && $request->date, function ($query) use ($request) {
                $query->whereDate($request->datetype, $request->date);
            })
            ->when($request->laboratory , function ($query, $labtype ) {
                // (is_array($labtype)) ?  
                $query->where('laboratory_id',$labtype );
                // : $query->where('laboratory_id',$labtype );
            }) 
            ->when($request->reminder, function ($query, $reminder) {
                switch($reminder){
                    case 'Memorandum of Agreement (MOA)':
                        $query->whereHas('payment', function ($query) {
                            $query->where('status_id',18)->where('paid_at',null);
                        });
                    break;
                    case 'Due Soon':
                        $query->whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])->where('status_id','!=',4);
                    break;
                    case 'Overdue Request':
                        $query->whereDate('due_at','<',Carbon::now());
                    break;
                    case 'Report Pending':
                        $query->whereHas('samples',function ($query){
                            $query->whereDoesntHave('report')->whereHas('analyses', function ($query) {
                                $query->where('status_id', 12);
                            });
                        });
                        $query->where('status_id',4)->whereIn('laboratory_type',$this->type);
                    break;
                    case 'For Release':
                        $query->where('status_id',4)->whereHas('release', function ($query) {
                            $query->where('status_id',26)->where('created_at','>=', Carbon::now()->subDays(30));
                        });
                    break;
                    case 'Unclaimed Reports':
                        $query->where('status_id',4)->whereHas('release', function ($query) {
                            $query->where('status_id',26)->where('created_at','<=', Carbon::now()->subDays(30));
                        });
                    break;
                    case 'Completed with no report number':
                        $query->where('status_id',4)->whereHas('samples', function ($query) {
                            $query->doesntHave('report');
                        }, '>', 0);
                    break;
                    case 'Ongoing Analyses':
                        $query->whereHas('samples.analyses', function ($q) {
                            $q->whereIn('status_id', [10,11]);
                        });
                    break;
                }
            })  
            ->when($request->type, function ($query, $type) {
                ($type == 'Referral') ? $query->where('is_referral',1) : $query->where('is_referral', 0);
            })
            ->when($month, function ($query, $month) {
                $query->whereMonth('created_at', $month);
            })
            ->when($request->year, function ($query, $year) {
                $query->whereYear('created_at', $year);
            })
            ->whereIn('status_id',[3,4])
            ->where(function ($query) {
                $query->whereHas('samples', function ($query) {
                    $query->where(function ($q) {
                        $q->whereDoesntHave('report')
                        ->orWhereHas('report', function ($q) {
                            $q->whereNull('code')
                            ->orWhere('code', '');
                        });
                    });
                })
                ->orWhereHas('payment', function ($query) {
                    $query->where('status_id', 18)
                        ->whereNull('paid_at');
                });
            })
            ->paginate($request->count)
        );
        return $data;
    }

    public function release($request){
        $month = $request->month ? Carbon::parse($request->month)->month : null;
        $data =  Tsr::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('laboratory:id,name','status:id,name,color,others')
            ->with('payment:tsr_id,id,total,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('code', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('customer', function ($q) use ($keyword) {
                        $q->join('customer_names', 'customers.name_id', '=', 'customer_names.id')
                        ->whereRaw("
                            CASE
                                WHEN customers.is_main = 1 THEN customer_names.name
                                ELSE CONCAT(customer_names.name, ' - ', customers.name)
                            END LIKE ?
                        ", ["%{$keyword}%"]);
                        });
                    });
            })
            ->where('status_id',4)
            ->whereHas('payment', function ($query) {
                $query->whereIn('status_id', [7,18])
                    ->whereNotNull('paid_at');
            })
            ->whereDoesntHave('samples', function ($query) {
                $query->where(function ($q) {
                    $q->whereDoesntHave('report')
                    ->orWhereHas('report', function ($q) {
                        $q->whereNull('code')
                            ->orWhere('code', '');
                    });
                });
            })
            ->when($request->laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id', $laboratory);
            })
            ->when($month, function ($query, $month) {
                $query->whereMonth('created_at', $month);
            })
            ->when($request->year, function ($query, $year) {
                $query->whereYear('created_at', $year);
            })
            ->get();

        return $data;
    }

    public function moa($request){
        $month = $request->month ? Carbon::parse($request->month)->month : null;
        $data =  Tsr::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('laboratory:id,name','status:id,name,color,others')
            ->with('payment:tsr_id,id,total,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('code', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('customer', function ($q) use ($keyword) {
                        $q->join('customer_names', 'customers.name_id', '=', 'customer_names.id')
                        ->whereRaw("
                            CASE
                                WHEN customers.is_main = 1 THEN customer_names.name
                                ELSE CONCAT(customer_names.name, ' - ', customers.name)
                            END LIKE ?
                        ", ["%{$keyword}%"]);
                        });
                    });
            })
            ->whereIn('status_id',[3,4])
            ->whereHas('payment', function ($query) {
                $query->where('status_id', 18)
                    ->whereNull('paid_at');
            })
            ->when($request->laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id', $laboratory);
            })
            ->when($month, function ($query, $month) {
                $query->whereMonth('created_at', $month);
            })
            ->when($request->year, function ($query, $year) {
                $query->whereYear('created_at', $year);
            })
           ->get();

        return $data;
    }

    public function counts($request){
        $month = $request->month ? Carbon::parse($request->month)->month : null;
        $year = $request->year;
        $laboratory = $request->laboratory;
        return [
            [
                'name' => 'Customer Served',
                'icon' => 'ri-account-circle-fill',
                'count' => Tsr::where('status_id',3)
                ->where(function ($query) {
                    $query->whereHas('samples', function ($query) {
                        $query->where(function ($q) {
                            $q->whereDoesntHave('report')
                            ->orWhereHas('report', function ($q) {
                                $q->whereNull('code')
                                ->orWhere('code', '');
                            });
                        });
                    })
                    ->orWhereHas('payment', function ($query) {
                        $query->where('status_id', 18)
                            ->whereNull('paid_at');
                    });
                })
                ->when($request->laboratory, function ($query, $laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at', $month);
                })
                ->whereYear('created_at',$year)->count(),
                'color' => 'text-primary',
                'info' => 'Number of customers with ongoing TSRs.'
            ],
            [
                'name' => 'Samples Received',
                'icon' => 'ri-inbox-archive-fill',
                'count' => TsrSample::whereYear('created_at',$year)
                ->whereHas('tsr', function ($query) use ($year,$month,$laboratory){
                    $query->where('status_id',3)->whereYear('created_at', $year)
                    ->when($month, function ($query, $month) {
                        $query->whereMonth('created_at', $month);
                    })
                    ->when($laboratory, function ($query, $laboratory) {
                        $query->where('laboratory_id', $laboratory);
                    })
                    ->where(function ($query) {
                        $query->whereHas('samples', function ($query) {
                            $query->where(function ($q) {
                                $q->whereDoesntHave('report')
                                ->orWhereHas('report', function ($q) {
                                    $q->whereNull('code')
                                    ->orWhere('code', '');
                                });
                            });
                        })
                        ->orWhereHas('payment', function ($query) {
                            $query->where('status_id', 18)
                                ->whereNull('paid_at');
                        });
                    });
                })->count(),
                'color' => 'text-danger',
                'info' => 'Total samples currently being processed.'
            ],
            [
                'name' => 'Services Conducted',
                'icon' => 'ri-flask-fill',
                'count' => TsrAnalysis::whereYear('created_at',$year)->whereHas('sample', function ($query) use ($year,$month,$laboratory){
                    $query->whereHas('tsr', function ($query) use ($year,$month,$laboratory){
                    $query->where('status_id',3)->whereYear('created_at', $year)
                        ->when($month, function ($query, $month) {
                            $query->whereMonth('created_at', $month);
                        })
                        ->when($laboratory, function ($query, $laboratory) {
                            $query->where('laboratory_id', $laboratory);
                        })
                        ->where(function ($query) {
                            $query->whereHas('samples', function ($query) {
                                $query->where(function ($q) {
                                    $q->whereDoesntHave('report')
                                    ->orWhereHas('report', function ($q) {
                                        $q->whereNull('code')
                                        ->orWhere('code', '');
                                    });
                                });
                            })
                            ->orWhereHas('payment', function ($query) {
                                $query->where('status_id', 18)
                                    ->whereNull('paid_at');
                            });
                        });
                    });
                })
               ->count(),
                'color' => 'text-info',
                'info' => 'Laboratory services requested and underway.'
            ]
        ];
    }

    public function dues($request){
        $year = $request->year;
        $month = $request->month ? Carbon::parse($request->month)->month : null;
        $laboratory = $request->laboratory;

        return [
            [
                'name' => 'Due Soon',
                'icon' => 'ri-error-warning-line',
                'count' => Tsr::whereBetween('due_at', [Carbon::now()->startOfDay(), Carbon::now()->addDays(5)->endOfDay()])
                ->where(function ($query) {
                    $query->whereHas('samples', function ($query) {
                        $query->where(function ($q) {
                            $q->whereDoesntHave('report')
                            ->orWhereHas('report', function ($q) {
                                $q->whereNull('code')
                                ->orWhere('code', '');
                            });
                        });
                    })
                    ->orWhereHas('payment', function ($query) {
                        $query->where('status_id', 18)
                            ->whereNull('paid_at');
                    });
                })
                ->when($laboratory, function ($query, $laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at', $month);
                })
                ->when($request->year, function ($query, $year) {
                    $query->whereYear('created_at', $year);
                })
                ->whereIn('status_id',[3,4])->count(),
                'color' => 'text-warning',
                'info' => '5 days ahead of the due date',
                'type' => 'Due Soon'
            ],
            [
                'name' => 'Overdue Request',
                'icon' => 'ri-error-warning-fill',
                'count' => Tsr::whereDate('due_at','<',now())
                ->where(function ($query) {
                    $query->whereHas('samples', function ($query) {
                        $query->where(function ($q) {
                            $q->whereDoesntHave('report')
                            ->orWhereHas('report', function ($q) {
                                $q->whereNull('code')->orWhere('code', '');
                            });
                        });
                    })
                    ->orWhereHas('payment', function ($query) {
                        $query->where('status_id', 18)
                            ->whereNull('paid_at');
                    });
                })
                ->when($laboratory, function ($query, $laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at', $month);
                })
                ->when($request->year, function ($query, $year) {
                    $query->whereYear('created_at', $year);
                })
                ->whereIn('status_id',[3,4])->count(),
                'color' => 'text-danger',
                'info' => 'Due date has already passed',
                'type' => 'Overdue Request'
            ]
        ];            
    }

    public function alerts($laboratories,$request){
        $year = $request->year;
        $month = $request->month ? Carbon::parse($request->month)->month : null;
        $laboratory = $request->laboratory;

        return [
            [
                'name' => 'Memorandum of Agreement',
                'count' => Tsr::whereIn('laboratory_id', $laboratories->pluck('value'))
                ->whereIn('status_id',[3,4])
                ->whereHas('payment', function ($query) { 
                    $query->where('status_id',18)->where('paid_at',null); 
                })
                ->when($laboratory, function ($query, $laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at', $month);
                })
                ->whereYear('created_at', $year)->count(),
                'icon' => 'ri-error-warning-fill text-warning',
                'type' => 'Memorandum of Agreement (MOA)',
                'info' => 'Total samples currently being processed.'
            ],
            [
                'name' => 'Ongoing Analyses',
                'count' => Tsr::whereIn('laboratory_id', $laboratories->pluck('value'))
                ->where('status_id', 3)
                ->whereHas('samples.analyses', function ($q) {
                    $q->whereIn('status_id', [10,11]);
                })
                ->when($laboratory, function ($query, $laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at', $month);
                })
                ->whereYear('created_at', $year)->count(),
                'icon' => 'ri-time-fill text-info',
                'type' => 'Ongoing Analyses',
                'info' => 'Total samples currently being processed.'
            ],
            [
                'name' => 'Pending Report',
                'count' => Tsr::whereIn('laboratory_id', $laboratories->pluck('value'))
                ->where('status_id', 4)
                ->whereHas('samples',function ($query){
                    $query->whereDoesntHave('report')->whereHas('analyses', function ($query) {
                        $query->where('status_id', 12);
                    });
                })
                ->when($laboratory, function ($query, $laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->when($month, function ($query, $month) {
                    $query->whereMonth('created_at', $month);
                })
                ->whereYear('created_at', $year)->count(),
                'icon' => 'ri-close-circle-fill text-danger',
                'type' => 'Completed with no report number',
                'info' => 'Total samples currently being processed.'
            ],
        ];
    }

}
