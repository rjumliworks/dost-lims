<?php

namespace App\Http\Controllers\Finance;

use App\Traits\HandlesTransaction;
use App\Services\DropdownClass;
use App\Services\Finance\Or\ViewClass;
use App\Services\Finance\Or\SaveClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\OrRequest;
use Illuminate\Http\Request;

class OrController extends Controller
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
            case 'print':
                return $this->view->print($request);
            break;
            default :
            return inertia('Finance/Cashiering/Receipts/Index',[
                'dropdowns' => [
                    'payments' => $this->dropdown->dropdowns('Payment Mode','n/a'),
                    'statuses' => $this->dropdown->statuses('Payment'),
                ]
            ]);
        }
    }

    public function store(OrRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->or($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

}
