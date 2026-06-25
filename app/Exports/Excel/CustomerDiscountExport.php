<?php

namespace App\Exports\Excel;

use App\Models\Tsr;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerDiscountExport implements FromView
{
    protected $month,$year,$lab;

    function __construct($month,$year,$lab) {
        $this->month = $month;
        $this->year = $year;
        $this->lab = $lab;
    }

    public function view(): View {

        $query = Tsr::with([
            'customer:id,name,sex_id,name_id,is_new',
            'customer.customer_name:id,name,classification_id,type_id',
            'payment.discounted'
        ])
        ->withCount([
            'samples',
            'samples as analyses_count' => function ($q) {
                $q->join('tsr_analyses', 'tsr_analyses.sample_id', '=', 'tsr_samples.id');
            }
        ])
        ->when($this->lab, function ($query, $laboratory) {
            $query->where('laboratory_id',$laboratory);
        })
        ->whereYear('created_at', $this->year)
        ->when($this->month !== null, function ($q){
            $q->whereMonth('created_at',$this->month);
        })
        ->where('status_id','!=',5)
        ->orderBy('code', 'ASC');

        if ($this->month) {
            $query->whereMonth('created_at', $this->month);
        }
        $tsrs = $query->get()->map(function ($item) {
            $discount = optional($item->payment->discounted)->name;
            $formattedDiscount = isset($item->payment->discount) ? $item->payment->discount : '-';

            $calibration = ($discount === 'Gratis - Calibration') ? $formattedDiscount : '-';
            $qc          = ($discount === 'Gratis - QC') ? $formattedDiscount : '-';
            $rd          = ($discount === 'Gratis - R&D') ? $formattedDiscount : '-';

            $health  = ($discount === 'Health Units') ? $formattedDiscount : '-';
            $student = ($discount === 'Student') ? $formattedDiscount : '-';
            $senior  = ($discount === 'Senior Citizen') ? $formattedDiscount : '-';
            $pwd     = ($discount === 'Persons with Disabilities') ? $formattedDiscount : '-';
            $women   = ($discount === 'Women\'s Month') ? $formattedDiscount : '-';

            $name = ($item->customer->name == 'Main') ? '' : ' - '.$item->customer->name;

            $subtotal = (float) str_replace([',', '₱'], '', $item->payment->subtotal);
            $discount = (float) str_replace([',', '₱'], '', $item->payment->discount);
            $total = (float) str_replace([',', '₱'], '', $item->payment->total);

            return [
                'code' => $item->code,
                'name' => $item->customer->customer_name->name.' '.$name,
                'samples' => $item->samples_count,
                'analyses' => $item->analyses_count,
                'fees'  => (float) str_replace([',', '₱'], '', $item->payment->total),
                'calibration' => $calibration,
                'qc' => $qc,
                'rd' => $rd,
                'health' => $health,
                'student' => $student,
                'senior' => $senior,
                'pwd' => $pwd,
                'women' => $women,
                'gross' => ($subtotal != $total) ? ($discount == '0.00') ?  $total : $subtotal : $subtotal
            ];
        });


        return view('exports.customer-discount', [
            'lists' => $tsrs
        ]);
    }
}
