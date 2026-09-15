<?php

namespace App\Services\Insights\Payment;

use App\Models\TsrPayment;

class MonitoringClass
{
    public function collection($request){
        $year = $request->year;
        $monthInput = $request->month;
        $month = is_null($monthInput) ? null : date('m', strtotime($monthInput));
        $laboratory = $request->laboratory;

        $scope = function ($query) use ($laboratory, $year, $month) {
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
        };

        return [
            [
                'name' => 'Collected Amount (Receipted)',
                'description' => 'Successfully collected and receipted',
                'total' => TsrPayment::whereHas('tsr', $scope)
                    ->where('status_id', 7)
                    ->where('is_paid', 1)
                    ->sum('total'),
                'icon' => 'ri-checkbox-circle-fill fs-20',
                'color' => 'text-success'
            ],
            [
                'name' => 'Uncollected Amount',
                'description' => 'Pending payments not yet received',
                'total' => TsrPayment::whereHas('tsr', $scope)
                    ->whereIn('status_id', [6, 18])
                    ->where('is_paid', 0)
                    ->where('is_child', 0)
                    ->sum('total'),
                'icon' => 'ri-close-circle-fill fs-20',
                'color' => 'text-danger'
            ],
            [
                'name' => 'Online Payment',
                'description' => 'Received online, pending cashier tagging',
                'total' => TsrPayment::whereHas('tsr', $scope)
                    ->where('status_id', 45)
                    ->where('is_paid', 0)
                    ->where('is_child', 0)
                    ->sum('total'),
                'icon' => 'ri-secure-payment-fill fs-20',
                'color' => 'text-info'
            ]
        ];
    }

    public function collection_summary($request){
        $year = $request->year;
        $monthInput = $request->month;
        $month = is_null($monthInput) ? null : date('m', strtotime($monthInput));
        $laboratory = $request->laboratory;

        $scope = function ($query) use ($laboratory, $year, $month) {
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
        };

        $discounted = TsrPayment::whereHas('tsr', $scope)->where('is_free', 0)->sum('discount');
        $complimentary = TsrPayment::whereHas('tsr', $scope)->where('is_free', 1)->sum('discount');

        return [
            [
                'name' => 'Discounted Service Amount',
                'description' => 'Value of discounts applied to paid services',
                'total' => $discounted,
                'icon' => 'ri-price-tag-3-fill fs-20',
                'color' => 'text-primary'
            ],
            [
                'name' => 'Complimentary Service Amount',
                'description' => 'Value of services free of charge',
                'total' => $complimentary,
                'icon' => 'ri-hearts-fill fs-20',
                'color' => 'text-warning'
            ]
        ];
    }
}
