<?php

namespace App\Http\Controllers\Finance;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Finance\OpOrExport;
use App\Exports\Finance\ReconciliationExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Common\Reports\ViewClass;

class ReportController extends Controller
{
    public ViewClass $view;

    public function __construct(ViewClass $view){
        $this->view = $view;
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
            default:
            return inertia('Modules/Reports/Index',[
                'types' => $this->view->types(),
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

        switch($request->type){
            case 'reconciliation':
                return Excel::download(
                    new ReconciliationExport($month,$year,$laboratory), 
                    'reconciliation-'.strtolower($month_name).'-'.$year.'.xlsx'
                );
            break;
             case 'opandor':
                return Excel::download(
                    new OpOrExport($month,$year,$laboratory), 
                    'opandor-'.strtolower($month_name).'-'.$year.'.xlsx'
                );
            break;
        }
    }
}
