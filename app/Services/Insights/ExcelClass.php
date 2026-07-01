<?php

namespace App\Services\Insights;

use Carbon\Carbon;

use App\Models\ListLaboratory;
use App\Exports\Excel\LocationExport;
use App\Exports\Excel\PerDiscountExport;
use App\Exports\Excel\CustomerDiscountExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelClass
{
    public function location($request){
        if ($request->month) {
            $monthInput = $request->month;
            $month = is_numeric($monthInput)
                ? (int) $monthInput
                : (int) date('m', strtotime($monthInput));
        } else {
            $month = null;
        }

        $monthName = $month
            ? Carbon::create()->month($month)->format('F')
            : 'All';
        $year = ($request->year) ? $request->year : date('Y');
        return Excel::download(new LocationExport($month,$year), 'CCS_'.$monthName.'_'.$year.'.xlsx');
    }
    
    public function discount($request){
      
         if ($request->month) {
            $monthInput = $request->month;
            $month = is_numeric($monthInput)
                ? (int) $monthInput
                : (int) date('m', strtotime($monthInput));
        } else {
            $month = null;
        }

        $monthName = $month
            ? Carbon::create()->month($month)->format('F')
            : 'All';
        $year = ($request->year) ? $request->year : date('Y');
        $lab = ($request->laboratory != 'null' && $request->laboratory) ? $request->laboratory : null;
        $lab_name = ($lab) ? ListLaboratory::where('id',$lab)->first()->name : 'All';
        return Excel::download(new CustomerDiscountExport($month,$year,$lab), 'CFS_'.$monthName.'_'.$lab_name.'_'.$year.'.xlsx');
    }

    public function perdiscount($request){
        $discount = $request->discount;
        if ($request->month) {
            $monthInput = $request->month;
            $month = is_numeric($monthInput)
                ? (int) $monthInput
                : (int) date('m', strtotime($monthInput));
        } else {
            $month = null;
        }

        $monthName = $month
            ? Carbon::create()->month($month)->format('F')
            : 'All';
        $year = ($request->year) ? $request->year : date('Y');
        $lab = ($request->laboratory != 'null' && $request->laboratory) ? $request->laboratory : null;
        return Excel::download(new PerDiscountExport($month,$year,$lab,$discount), 'CDS_'.$monthName.'_'.$year.'.xlsx');
    }
}
