<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Services\Others\Inventory\SaveClass;
use App\Services\Others\Inventory\ViewClass;
use App\Http\Requests\Others\InventoryRequest;

class InventoryController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected SaveClass $save;
    protected AgencyClass $agency;
    protected DropdownClass $dropdown;

    public function __construct(AgencyClass $agency, DropdownClass $dropdown, SaveClass $save, ViewClass $view){
        $this->dropdown = $dropdown;
        $this->view = $view;
        $this->save = $save;
        $this->agency = $agency;
    }

    public function index(Request $request){
        switch($request->option){
            case 'items':
                return $this->view->items($request);
            break;
            case 'stockin':
                return $this->view->stockin($request);
            break;
            case 'stockout':
                return $this->view->stockout($request);
            break;
            case 'fetch':
                return $this->view->dashboard($request,$this->dropdown->statuses('Equipment'));
            break;
            default :
            return inertia('Others/Inventory/Index',[
                'dropdowns' => [
                    'laboratories' => $this->agency->laboratories(),
                    'categories' => $this->dropdown->dropdowns('Inventory','Category'),
                    'units' => $this->dropdown->dropdowns('Inventory','Unit'),
                ]
            ]);
        }
    }

    public function show($id){
        $item = $this->view->view($id);
        return inertia('Others/Inventory/Profile/Index',[
            'item' => $item,
            'dropdowns' => [
                'categories' => $this->dropdown->dropdowns('Inventory','Category'),
                'suppliers' => $this->dropdown->suppliers(),
                'units' => $this->dropdown->dropdowns('Inventory','Unit'),
            ],
        ]);
    }

    public function store(InventoryRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'item':
                    return $this->save->item($request);
                break;
                case 'stock':
                    return $this->save->stock($request);
                break;
            }
        });
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->stockUpdate($request);
        });
        
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }
}
