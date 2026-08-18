<?php

namespace App\Services\Common\Reports;

use App\Models\ListLaboratory;
use App\Models\Tsr;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AccomplishmentExport;
use App\Services\Insights\AccomplishmentClass;
use App\Services\Insights\Performance\ViewClass as PerformanceView;

class ViewClass
{
    protected AccomplishmentClass $accomplishment;
    protected PerformanceView $performance;

    public function __construct(AccomplishmentClass $accomplishment, PerformanceView $performance){
        $this->accomplishment = $accomplishment;
        $this->performance = $performance;
    }

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
        $name = ListLaboratory::where('id',$request->laboratory)->value('short');

        return Excel::download(new AccomplishmentExport($month,$year,$lab), $name.'_'.strtolower($request->month).'_accomplishment.xlsx');
    }

    public function executiveSummary($request){
        $month = $request->month ?: date('F');
        $year = $request->year ?: date('Y');
        $monthNumber = \DateTime::createFromFormat('F', ucfirst(strtolower($month)))->format('m');

        $accomplishment = $this->accomplishment->accomplish(Request::create('/', 'GET', [
            'type' => 'monthly',
            'month' => $month,
            'year' => $year,
        ]));

        $topCustomers = $this->performance->customers(Request::create('/', 'GET', [
            'by' => 'By Month',
            'month' => $month,
            'year' => $year,
        ]), 5)->map(function ($item) {
            $suffix = ($item->name == 'Main') ? '' : ' - '.$item->name;
            return [
                'name' => $item->customer_name->name.$suffix,
                'count' => $item->tsrs_count,
            ];
        })->values();

        $referral = [
            'Local' => Tsr::where('status_id', '!=', 5)
                ->where('is_referral', 0)
                ->whereMonth('created_at', $monthNumber)
                ->whereYear('created_at', $year)
                ->count(),
            'Referral' => Tsr::where('status_id', '!=', 5)
                ->where('is_referral', 1)
                ->whereMonth('created_at', $monthNumber)
                ->whereYear('created_at', $year)
                ->count(),
        ];

        return [
            'month' => $month,
            'year' => $year,
            'laboratories' => $accomplishment['lists'],
            'totals' => $accomplishment['footer'][0],
            'top_customers' => $topCustomers,
            'referral' => $referral,
        ];
    }

    public function print($request){
        $data = $this->executiveSummary($request);

        $pdf = \PDF::loadView('reports.executive-summary', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('executive-summary-'.strtolower($data['month']).'-'.$data['year'].'.pdf');
    }
}
