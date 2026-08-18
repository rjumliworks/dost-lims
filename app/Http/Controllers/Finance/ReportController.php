<?php

namespace App\Http\Controllers\Finance;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Finance\OpOrExport;
use App\Exports\RstlExport;
use App\Exports\TsrExport;
use App\Exports\Finance\ReconciliationExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AgencyClass;
use App\Services\Common\Reports\ViewClass;
use App\Models\ListLaboratory;

class ReportController extends Controller
{
    public ViewClass $view;
    protected AgencyClass $agency;

    public function __construct(ViewClass $view, AgencyClass $agency){
        $this->view = $view;
        $this->agency = $agency;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return [
                    'laboratories' => $this->view->accomplishments($request)
                ];
            break;
            case 'excel':
                return $this->view->excel($request);
            break;
            case 'print':
                return $this->view->print($request);
            break;
            default:
            return inertia('Modules/Reports/Index',[
                'types' => $this->agency->laboratories(),
                'info' => [
                    'month' => \DateTime::createFromFormat('!m', date('m'))->format('F'),
                    'year' => date('Y')
                ]
            ]);
        }
    }


    public function excel(Request $request)
    {
        $month_name = $request->month ?: date('F');
        $month = \DateTime::createFromFormat('F', ucfirst(strtolower($month_name)))->format('m');
        $year = $request->year ?: date('Y');
        $laboratory = $request->laboratory;
        $lab_name = ($laboratory) ? ListLaboratory::where('id',$laboratory)->value('short') : '';
        $lab_suffix = $lab_name ? '-' . \Illuminate\Support\Str::slug($lab_name) : '';
    
        switch ($request->type) {
            case 'reconciliation':
                return Excel::download(
                    new ReconciliationExport($month, $year, $laboratory),
                    "reconciliation{$lab_suffix}-" . strtolower($month_name) . "-{$year}.xlsx"
                );

            case 'opandor':
                return Excel::download(
                    new OpOrExport($month, $year, $laboratory),
                    "opandor{$lab_suffix}-" . strtolower($month_name) . "-{$year}.xlsx"
                );

            case 'rstldata':
                return Excel::download(
                    new RstlExport($month, $year, $laboratory),
                    "rstl{$lab_suffix}-" . strtolower($month_name) . "-{$year}.xlsx"
                );

            case 'tsrs':
                return Excel::download(
                    new TsrExport($month, $year, $laboratory),
                    "tsr{$lab_suffix}-" . strtolower($month_name) . "-{$year}.xlsx"
                );
        }
    }
}
