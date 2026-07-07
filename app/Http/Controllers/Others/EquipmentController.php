<?php

namespace App\Http\Controllers\Others;

use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Http\Requests\Others\EquipmentRequest;
use App\Services\Others\Equipments\SaveClass;
use App\Services\Others\Equipments\ViewClass;

class EquipmentController extends Controller
{
    use HandlesTransaction;

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

    public function store(EquipmentRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            if($request->option == 'perform'){
                return $this->save->perform($request);
            }else{
                return $this->save->save($request);
            }
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function show($id){
        $item = $this->view->view($id);
        return inertia('Others/Equipments/Profile/Index',[
            'equipment' => $item,
            'dropdowns' => [
                'categories' => $this->dropdown->dropdowns('Inventory','Category'),
                'suppliers' => $this->dropdown->suppliers(),
                'units' => $this->dropdown->dropdowns('Inventory','Unit'),
            ],
        ]);
    }

    public function destroy($id)
    {
        $result = $this->handleTransaction(function () use ($id){
            return $this->save->delete($id);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }
}
