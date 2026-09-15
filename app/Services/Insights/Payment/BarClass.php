<?php

namespace App\Services\Insights\Payment;

use App\Models\TsrPayment;

class BarClass
{
    public function data($request){
        $year = ($request->year) ? $request->year : date('Y');
        $laboratory = $request->laboratory;
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        $collected = [];
        $uncollected = [];
        $complimentary = [];

        for ($month = 1; $month <= 12; $month++) {
            $collected[] = (float) TsrPayment::whereHas('tsr', function ($query) use ($laboratory, $year, $month) {
                    $query->where('status_id', '!=', 5);
                    $query->when($laboratory, function ($query, $laboratory) {
                        $query->where('laboratory_id', $laboratory);
                    });
                    $query->whereYear('created_at', $year);
                    $query->whereMonth('created_at', $month);
                })
                ->where('status_id', 7)
                ->where('is_paid', 1)
                ->sum('total');

            $uncollected[] = (float) TsrPayment::whereHas('tsr', function ($query) use ($laboratory, $year, $month) {
                    $query->where('status_id', '!=', 5);
                    $query->when($laboratory, function ($query, $laboratory) {
                        $query->where('laboratory_id', $laboratory);
                    });
                    $query->whereYear('created_at', $year);
                    $query->whereMonth('created_at', $month);
                })
                ->whereIn('status_id', [6, 18])
                ->where('is_paid', 0)
                ->where('is_child', 0)
                ->sum('total');

            $complimentary[] = (float) TsrPayment::whereHas('tsr', function ($query) use ($laboratory, $year, $month) {
                    $query->where('status_id', '!=', 5);
                    $query->when($laboratory, function ($query, $laboratory) {
                        $query->where('laboratory_id', $laboratory);
                    });
                    $query->whereYear('created_at', $year);
                    $query->whereMonth('created_at', $month);
                })
                ->where('is_free', 1)
                ->sum('discount');
        }

        return [
            'categories' => $months,
            'lists' => [
                ['name' => 'Collected Amount', 'data' => $collected],
                ['name' => 'Uncollected Amount', 'data' => $uncollected],
                ['name' => 'Complimentary Service Amount', 'data' => $complimentary],
            ],
        ];
    }
}
