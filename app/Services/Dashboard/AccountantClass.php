<?php

namespace App\Services\Dashboard;

use App\Models\Tsr;
use App\Models\TsrPayment;
use App\Http\Resources\Finance\TsrNoPaymentResource;

class AccountantClass
{
    public function __construct()
    {
        $this->facility =(\Auth::check()) ? \Auth::user()->profile?->facility_id : null;
    }

    public function reminders(){
        return [
            [
                'name' => 'Memorandum of Agreement (MOA)',
                'short' => 'TSR payment covered by the contract',
                'count' => TsrPayment::where('status_id',18)
                ->whereHas('tsr', function ($query) {
                    $query->when($this->facility, function ($query){
                        $query->where('facility_id', $this->facility);
                    });
                })
                ->sum('total'),
                'icon' => 'ri-secure-payment-line',
                'color' => 'bg-info-subtle text-info'
            ],
            [
                'name' => 'Pending Collections',
                'short' => 'Awaiting for payment',
                'count' => TsrPayment::where('status_id',6)
                ->whereHas('tsr', function ($query) {
                    $query->when($this->facility, function ($query){
                        $query->where('facility_id', $this->facility);
                    });
                })
                ->sum('total'),
                'icon' => 'ri-hand-coin-line',
                'color' => 'bg-warning-subtle text-warning'
            ],
            [
                'name' => 'Total Collections',
                'short' => 'Payment successfully collected',
                'count' => TsrPayment::whereYear('paid_at',now())
                ->whereHas('tsr', function ($query) {
                    $query->when($this->facility, function ($query){
                        $query->where('facility_id', $this->facility);
                    });
                })
                ->where('status_id',7)->sum('total'),
                'icon' => 'ri-hand-coin-fill',
                'color' => 'bg-success-subtle text-success'
            ],
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
