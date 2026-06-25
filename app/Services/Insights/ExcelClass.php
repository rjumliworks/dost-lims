<?php

namespace App\Services\Insights;

use Carbon\Carbon;
use App\Exports\Excel\LocationExport;
use App\Exports\Excel\PerDiscountExport;
use App\Exports\Excel\CustomerDiscountExport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelClass
{
    public function location($request){
        if($request->month){
            $monthInput = $request->month ?? null;
            $month = is_numeric($monthInput) ? (int) $monthInput : date('m', strtotime($monthInput));
        }else{
            $month = null;
        }
        $monthName = Carbon::create()->month($month)->format('F');
        $year = ($request->year) ? $request->year : date('Y');
        return Excel::download(new LocationExport($month,$year), 'CCS_'.$monthName.'_'.$year.'.xlsx');
    }
    
    public function discount($request){
        if($request->month){
            $monthInput = $request->month ?? null;
            $month = is_numeric($monthInput) ? (int) $monthInput : date('m', strtotime($monthInput));
        }else{
            $month = null;
        }
        $year = ($request->year) ? $request->year : date('Y');
        $monthName = Carbon::create()->month($month)->format('F');
        $lab = ($request->laboratory != 'null' && $request->laboratory) ? $request->laboratory : null;
        return Excel::download(new CustomerDiscountExport($month,$year,$lab), 'CFS_'.$monthName.'_'.$year.'.xlsx');
    }

    public function perdiscount($request){
        $discount = $request->discount;
        if($request->month && $request->month != 'null'){
            $monthInput = $request->month ?? null;
            $month = is_numeric($monthInput) ? (int) $monthInput : date('m', strtotime($monthInput));
        }else{
            $month = null;
        }
        $monthName = Carbon::create()->month($month)->format('F');
        $year = ($request->year) ? $request->year : date('Y');
        $lab = ($request->laboratory != 'null' && $request->laboratory) ? $request->laboratory : null;
        return Excel::download(new PerDiscountExport($month,$year,$lab,$discount), 'CDS_'.$monthName.'_'.$year.'.xlsx');
    }
}
