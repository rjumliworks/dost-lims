<?php

namespace App\Services\Dashboard;

use App\Models\Tsr;
use App\Models\TsrPayment;
use App\Models\FinanceOp;
use App\Http\Resources\Finance\TsrNoPaymentResource;

class AccountantClass
{
    public function __construct()
    {
        $this->facility =(\Auth::check()) ? \Auth::user()->profile?->facility_id : null;
    }

    public function counts($statuses){
        foreach($statuses as $status){
            $counts[] = FinanceOp::where('payment_id',$status['value'])->where('status_id',6)
            ->count();
        }
        return $counts;
    }

    public function collection_summary($request){
        $year = date('Y');
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
                'color' => 'text-purple'
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


    public function collection($request){
        $sort = ($request->sort) ? $request->sort : 'desc';
        $year = date('Y');
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

    public function reminders(){
        return [
            [
                'name' => 'Memorandum of Agreement (MOA)',
                'description' => 'TSR payment covered by the contract',
                'total' => TsrPayment::where('status_id',18)
                ->whereHas('tsr', function ($query) {
                    $query->when($this->facility, function ($query){
                        $query->where('facility_id', $this->facility);
                    });
                })
                ->sum('total'),
                'icon' => 'ri-error-warning-fill fs-20',
                'color' => 'text-warning'
            ]
        ];
    }

    public function forpayment($request){
        $data = TsrNoPaymentResource::collection(
            Tsr::query()
            ->with('customer:id,name_id,name,is_main','customer.customer_name:id,name,has_branches')
            ->with('payment:tsr_id,id,total,subtotal,discount,or_number,is_paid,is_free,paid_at,status_id,discount_id,collection_id,payment_id','payment.status:id,name,color,others')
            ->when($request->keyword, function ($query, $keyword) {
                $query->where('code', 'LIKE', "%{$keyword}%")
                ->orWhereHas('customer',function ($query) use ($keyword) {
                    $query->whereHas('customer_name',function ($query) use ($keyword) {
                        $query->where('name', 'LIKE', "%{$keyword}%");
                    });
                });
            })
            ->when($this->facility, function ($query){
                $query->where('facility_id', $this->facility);
            })
            ->whereHas('payment',function ($query){
                $query->where('payment_id',NULL)->where('collection_id',NULL);
            })
            ->where('status_id',2)
            ->get()
        );
        return $data;
    }
}
