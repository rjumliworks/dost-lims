<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AgencyClass;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Services\Common\Category\ViewClass;
use App\Services\Common\Category\SaveClass;
use App\Http\Requests\Common\CategoryRequest;

class CategoryController extends Controller
{
    use HandlesTransaction;

    protected DropdownClass $dropdown;
    protected ViewClass $view;
    protected SaveClass $save;
    protected AgencyClass $agency;

    public function __construct(DropdownClass $dropdown, SaveClass $save, ViewClass $view, AgencyClass $agency){
        $this->dropdown = $dropdown;
        $this->view = $view;
        $this->save = $save;
        $this->agency = $agency;
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
            case 'name':
                return $this->view->name($request);
            break;
             case 'names':
                return $this->view->names($request);
            break;
            default:
            return inertia('Modules/Categories/Index',[
                'dropdowns' => [
                    'laboratories' => $this->agency->laboratories(),
                    'categories' => $this->dropdown->categories(),
                ]
            ]);
        }
    }

    public function store(CategoryRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'category':
                    return $this->save->category($request);
                break;
                case 'type':
                    return $this->save->type($request);
                break;
                case 'name':
                    return $this->save->name($request);
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

}
