<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Services\Common\Monitoring\ViewClass;

class MonitoringController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected AgencyClass $agency;
    protected DropdownClass $dropdown;

    public function __construct(ViewClass $view, AgencyClass $agency, DropdownClass $dropdown){
        $this->view = $view;
        $this->dropdown = $dropdown;
        $this->agency = $agency;
    }

    public function index(Request $request){
        switch($request->option){
            case 'list':
                return $this->view->list($request);
            break;
            case 'counts':
                return $this->view->dashboard($request,$this->agency->laboratories());
            break;
            default:
            return inertia('Modules/Monitoring/Index',[
                'dropdowns' => [
                    'laboratories' => $this->agency->laboratories(),
                    'services' => $this->agency->services(),
                    'discounts' => $this->agency->discounts(),
                    'agencies' => $this->agency->all(),
                    'statuses' => $this->dropdown->statuses('Request'),
                    'purposes' => $this->dropdown->dropdowns('Purpose','n/a'),
                    'releases' => $this->dropdown->datas('Release'),
                    'regions' => $this->dropdown->regions(),
                    'years' => $this->dropdown->years()
                ],
            ]);
        }
    }

}
