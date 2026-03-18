<?php

namespace App\Services\Insights\Customer;

use App\Models\Tsr;

class DiscountClass
{
    public function data($request)
    {
        $laboratory = $request->laboratory;
        $year = $request->year;
        $monthInput = $request->month;

        if (is_null($monthInput)) {
            $month = date('m'); // current month (01–12)
        } else {
            $month = date('m', strtotime($monthInput));
        }

        $query = Tsr::with([
            'customer:id,name,name_id,is_new',
            'customer.customer_name:id,name',
            'payment.discounted'
        ])
        ->withCount([
            'samples',
            'samples as analyses_count' => function ($q) {
                $q->join('tsr_analyses', 'tsr_analyses.sample_id', '=', 'tsr_samples.id');
            }
        ])
        ->when($laboratory, function ($query, $laboratory) {
            $query->where('laboratory_id',$laboratory);
        })
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->where('status_id','!=',5)
        ->orderBy('code', 'ASC');

        if ($month) {
            $query->whereMonth('created_at', $month);
        }
        return $query->get()->map(function ($item) {
            $discount = optional($item->payment->discounted)->name;
            $formattedDiscount = isset($item->payment->discount) ? '₱' . number_format($item->payment->discount, 2) : '-';

            $calibration = ($discount === 'Gratis - Calibration') ? $formattedDiscount : '-';
            $qc          = ($discount === 'Gratis - QC') ? $formattedDiscount : '-';
            $rd          = ($discount === 'Gratis - R&D') ? $formattedDiscount : '-';

            $health  = ($discount === 'Health Units') ? $formattedDiscount : '-';
            $student = ($discount === 'Student') ? $formattedDiscount : '-';
            $senior  = ($discount === 'Senior Citizen') ? $formattedDiscount : '-';
            $pwd     = ($discount === 'Persons with Disabilities') ? $formattedDiscount : '-';
            $women   = ($discount === 'Women\'s Month') ? $formattedDiscount : '-';

            $name = ($item->customer->name == 'Main') ? '' : ' - '.$item->customer->name;

            return [
                'code' => $item->code,
                'name' => $item->customer->customer_name->name.' '.$name,
                'samples' => $item->samples_count,
                'analyses' => $item->analyses_count,
                'fees' => $item->payment->total,
                'calibration' => $calibration,
                'qc' => $qc,
                'rd' => $rd,
                'health' => $health,
                'student' => $student,
                'senior' => $senior,
                'pwd' => $pwd,
                'women' => $women,
                'gross' => ($item->payment->subtotal != $item->payment->total) ? ($item->payment->discount == '0.00') ? $item->payment->total : $item->payment->subtotal : $item->payment->subtotal
               
            ];
        });
    }

}
