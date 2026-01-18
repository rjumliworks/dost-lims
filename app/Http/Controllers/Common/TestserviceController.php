<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DropdownClass;
use App\Traits\HandlesTransaction;
use App\Services\Common\Testservice\ViewClass;
use App\Services\Common\Testservice\SaveClass;

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
                ],
                'counts' => $this->view->counts($this->dropdown->statuses('Testservice'))
            ]);
        }
    }

    public function store(NameRequest $request){
        $option = $request->option;
        switch($option){
            case 'add':
                return $this->save->add($request);
            break;
            case 'status':
                return $this->save->status($request);
            break;
            case 'create':
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->save->create($request);
                });
                return back()->with([
                    'data' => $result['data'],
                    'message' => $result['message'],
                    'info' => $result['info'],
                    'status' => $result['status'],
                ]);
            break;
            case 'fee':
                $result = $this->handleTransaction(function () use ($request) {
                    return $this->save->fee($request);
                });
                return back()->with([
                    'data' => $result['data'],
                    'message' => $result['message'],
                    'info' => $result['info'],
                    'status' => $result['status'],
                ]);
            break;
            case 'method':
                return $this->save->method($request);
            break;
        }
    }
}
