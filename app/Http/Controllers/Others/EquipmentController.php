<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Others\Equipments\SaveClass;
use App\Services\Others\Equipments\ViewClass;

class EquipmentController extends Controller
{
    protected ViewClass $view;
    protected SaveClass $save;
    protected DropdownClass $dropdown;

    public function __construct(DropdownClass $dropdown, SaveClass $save, ViewClass $view){
        $this->dropdown = $dropdown;
        $this->view = $view;
        $this->save = $save;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->view->lists($request);
            break;
            case 'fetch':
                return $this->view->dashboard($request,$this->dropdown->statuses('Equipment'));
            break;
            default :
            return inertia('Others/Equipments/Index',[
                'dropdowns' => [
                    'statuses' => $this->dropdown->statuses('Equipment'),
                    'regions' => $this->dropdown->regions(),
                    'laboratories' => $this->dropdown->laboratories(),
                    'equipments' => $this->dropdown->dropdowns('Equipment','n/a'),
                    'suppliers' => $this->dropdown->suppliers(),
                    'calibrations' => $this->view->calibrations($request),
                    'maintenances' => $this->view->maintenances($request),
                ]
            ]);
        }
    }
}
