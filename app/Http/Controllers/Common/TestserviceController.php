<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Services\Common\Category\ViewClass;
use App\Services\Common\Category\SaveClass;

class TestserviceController extends Controller
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
            case 'list':
                return $this->view->list($request);
            break;
            case 'category':
                return $this->view->category($request);
            break;
            case 'type':
                return $this->view->type($request);
            break;
            default:
            return inertia('Modules/Testservices/Index',[
                'dropdowns' => [
                    'laboratories' => $this->dropdown->laboratories(),
                    'statuses' => $this->dropdown->statuses('Testservice')
                ]
            ]);
        }
    }
}
