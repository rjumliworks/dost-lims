<?php

namespace App\Services\Common\Reports;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccomplishmentExport;

class ViewClass
{
    public function types(){
        return [];
    }

    public function accomplishments($request){
        return [];
    }

    public function excel($request){
        $month = ($request->month) ? \DateTime::createFromFormat('F', $request->month)->format('m') : date('m');  
        $year = ($request->year) ? $request->year : date('Y');
        $lab = $request->laboratory;
        $name = $request->labname;

        return Excel::download(new AccomplishmentExport($month,$year,$lab), $name.'_'.strtolower($request->month).'_accomplishment.xlsx');
    }
}
