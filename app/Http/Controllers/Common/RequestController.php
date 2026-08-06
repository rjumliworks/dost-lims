<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HandlesTransaction;
use App\Services\DropdownClass;
use App\Services\Common\Request\ViewClass;
use App\Http\Requests\Common\RequestActionRequest;

class RequestController extends Controller
{
    use HandlesTransaction;

    protected ViewClass $view;
    protected DropdownClass $dropdown;

    public function __construct(ViewClass $view, DropdownClass $dropdown){
        $this->view = $view;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'lists':
                return $this->view->lists($request, $this->dropdown->statuses('Amendment'));
            break;
            default:
            return inertia('Modules/Requests/Index',[
                'dropdowns' => [
                    'statuses' => $this->dropdown->statuses('Amendment'),
                ]
            ]);
        }
    }

    public function store(RequestActionRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'approve':
                    return $this->view->approve($request);
                break;
                case 'reject':
                    return $this->view->reject($request);
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
