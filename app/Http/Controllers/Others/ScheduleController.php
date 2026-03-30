<?php

namespace App\Http\Controllers\Others;

use App\Traits\HandlesTransaction; 
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Others\Schedules\SaveClass;
use App\Services\Others\Schedules\ViewClass;

class ScheduleController extends Controller
{
    use HandlesTransaction;

    public function __construct(DropdownClass $dropdown, AgencyClass $agency, SaveClass $save, ViewClass $view){
        $this->dropdown = $dropdown;
        $this->agency = $agency;
        $this->view = $view;
        $this->save = $save;
    }

    public function index(Request $request){
        switch($request->option){
            case 'events':
                // return $this->view->events($request);
                return [];
            break;
            case 'dues':
                // return $this->view->dues($request);
                return [];
            break;
            default :
            return inertia('Others/Schedules/Index',[
                'dropdowns' => [
                    'events' => $this->dropdown->events(),
                    'laboratories' => $this->agency->laboratories()
                ]
            ]);
        }
    }
}
