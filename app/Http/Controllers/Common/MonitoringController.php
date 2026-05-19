<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\AgencyClass;
use App\Services\DropdownClass;

class MonitoringController extends Controller
{
    use HandlesTransaction;

    protected AgencyClass $agency;
    protected DropdownClass $dropdown;

    public function __construct(AgencyClass $agency, DropdownClass $dropdown){
        $this->dropdown = $dropdown;
        $this->agency = $agency;
    }

    public function index(Request $request){
        switch($request->option){
            // case 'list':
            //     return $this->view->list($request);
            // break;
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
