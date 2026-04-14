<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Services\Others\Inventory\SaveClass;
use App\Services\Others\Inventory\ViewClass;

class InventoryController extends Controller
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
            return inertia('Others/Inventory/Index');
        }
    }
}
