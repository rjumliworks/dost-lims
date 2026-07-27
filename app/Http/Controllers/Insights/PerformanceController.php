<?php

namespace App\Http\Controllers\Insights;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AgencyClass;
use App\Services\Insights\Performance\ViewClass;

class PerformanceController extends Controller
{
    public ViewClass $view;
    protected AgencyClass $agency;

    public function __construct(ViewClass $view, AgencyClass $agency){
        $this->view = $view;
        $this->agency = $agency;
    }

     public function index(Request $request){
        switch($request->option){
            case 'accomplishment':
                return $this->view->accomplish($request);
            break;
            case 'top':
                return [
                    'samples_new' => $this->view->samples($request),
                    'samples_old' => $this->view->old_samples($request),
                    'analyses' => $this->view->analyses($request),
                    'customers' => $this->view->customers($request),
                    'total_sample_new' => $this->view->totalsamples(),
                    'total_sample_old' => $this->view->totaloldsamples()
                ];
            break;
            case 'excel':
                return $this->view->excel($request);
            break;
            case 'print':
                return $this->view->print($request);
            break;
            default:
            return inertia('Modules/Insights/Performance/Index',[
                'types' => $this->agency->laboratories(),
                'info' => [
                    'month' => \DateTime::createFromFormat('!m', date('m'))->format('F'),
                    'year' => date('Y')
                ]
            ]);
        }
    }
}
